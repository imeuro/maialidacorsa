#!/usr/bin/python
# -*- coding: UTF-8 -*-

"""
This scripts allows you to transfer ZenPhoto content to WordPress.

It browse the MySQL database of a ZenPhoto instance and generate an XML file. The XML produced is a WXR file (WordPress eXtended RSS), which mean it can be imported into a WordPress site.

A ZenPhoto album is imported as a post with a [gallery] tag in it.
All images of an album are imported as attachements and tied to the post it belongs to.

The script currently doesn't take care of sub-albums, as I didn't had any to migrate.

The script requires the following python modules:
    * lxml
    * PyMySQL

These can easely be installed on Debian with the following commands:
    $ aptitude install python-pip python-lxml
    $ pip install PyMySQL
"""

import lxml
import pymysql
import email.utils
import time
from lxml import etree


## Configuration

MYSQL_HOST = '127.0.0.1'
MYSQL_PORT = 3306
MYSQL_USER = 'root'
MYSQL_PASSWORD = 'ricorda'

ZENPHOTO_DB = 'zp_maialidacorsa'
ZENPHOTO_TABLE_PREFIX ='zp_'
ZENPHOTO_ALBUM_ROOT_URL = 'http://maialidacorsa-zp.dev/mdc/news'

WORDPRESS_ROOT_URL = 'http://maialidacorsa-wp.dev'

XML_FILEPATH = './zenphoto-news-export.xml'

## End of configuration


NS_EXCERPT = "http://wordpress.org/export/1.2/excerpt/"
NS_CONTENT = "http://purl.org/rss/1.0/modules/content/"
NS_WFW = "http://wellformedweb.org/CommentAPI/"
NS_DC = "http://purl.org/dc/elements/1.1/"
NS_WP = "http://wordpress.org/export/1.2/"

EXCERPT = "{%s}" % NS_EXCERPT
CONTENT = "{%s}" % NS_CONTENT
WFW = "{%s}" % NS_WFW
DC = "{%s}" % NS_DC
WP = "{%s}" % NS_WP

NSMAP = {
    'excerpt': NS_EXCERPT,
    'content': NS_CONTENT,
    'wfw': NS_WFW,
    'dc': NS_DC,
    'wp': NS_WP,
    }

conn = pymysql.connect(host=MYSQL_HOST, port=MYSQL_PORT, user=MYSQL_USER, passwd=MYSQL_PASSWORD, db=ZENPHOTO_DB)
cr = conn.cursor()

def query(table_name, columns, extra=''):
    """
    Utility method to query the database
    """
    results = []
    q = "SELECT %s FROM %s%s %s" % (
        ', '.join(["`%s`" % c for c in columns]),
        ZENPHOTO_TABLE_PREFIX,
        table_name,
        extra,
        )
    cr.execute(q)
    for row in cr.fetchall():
        cleaned_row_values = []
        for r in row:
            if isinstance(r, str):
                cleaned_row_values.append(r.decode('ISO-8859-1'))
            else:
                cleaned_row_values.append(r)
        results.append(dict(zip(columns, cleaned_row_values)))
    return results

# Utility method to clean up multi-line HTML text.
clean_text = lambda s: s.replace('\r\n', '\n').strip().replace('\n', "<br />")
rfc822_date = lambda d: email.utils.formatdate(time.mktime(d.timetuple()))

#albums = query('albums', ['id', 'folder', 'title', 'desc', 'date'])
#photos = query('images', ['id', 'albumid', 'filename', 'title', 'desc', 'sort_order', 'date'])
#photo_comments = query('comments', ['id', 'ownerid', 'name', 'email', 'website', 'date', 'comment', 'IP'], "WHERE type='images'")
news = query('news', ['id', 'titlelink', 'title', 'content', 'date'])


# Shift all IDs to prevent WordPress collisions
# MYSQL_LAST_INCREMENT = 50000
# SELECT Auto_increment
# FROM information_schema.tables
# WHERE table_schema = DATABASE() AND table_name='coolcavepress_posts';
#for row_list in [albums, photos, photo_comments]:
#    for row in row_list:
#        for column in ['id', 'albumid']:
#            if column in row:
#                row[column] = row[column] + MYSQL_LAST_INCREMENT

items = []

# Create an attachment for each photo


# Create one post for each album
for singlenews in news:
    # Prepare content
    title = singlenews['title'].strip()
    body = "[post]"
    if singlenews.get('content', None):
        body = "%s\n\n%s" % (singlenews['content'], body)
        body = clean_text(body)
    url = "%s/?p=%s" % (WORDPRESS_ROOT_URL, singlenews['id'])
    # Build the XML item
    post = etree.Element("item")
    etree.SubElement(post, "title").text = title
    etree.SubElement(post, "link").text = url
    etree.SubElement(post, "pubDate").text = rfc822_date(singlenews['date'])
    etree.SubElement(post, DC + "creator").text = 'admin'
    etree.SubElement(post, "guid", attrib={"isPermaLink": "false"}).text = url
    etree.SubElement(post, CONTENT + "encoded").text = etree.CDATA(body)
    etree.SubElement(post, WP + "post_id").text = str(singlenews['id'])
    etree.SubElement(post, WP + "post_date").text = singlenews['date'].isoformat(' ')
    etree.SubElement(post, WP + "post_date_gmt").text = singlenews['date'].isoformat(' ')
    etree.SubElement(post, WP + "status").text = "publish"
    etree.SubElement(post, WP + "post_type").text = "post"
    #etree.SubElement(post, "category", attrib={"domain": "category", "nicename": "photos"}).text = etree.CDATA("Photos")
    items.append(post)

# Generate the final XML document
channel = etree.Element("channel")
etree.SubElement(channel, WP + "wxr_version").text = "1.2"
for item in items:
    channel.append(item)
root = etree.Element("rss", attrib={"version": "2.0"}, nsmap=NSMAP)
root.append(channel)

f = open(XML_FILEPATH, 'w')
f.write(etree.tostring(root, xml_declaration=True, pretty_print=True, encoding='UTF-8'))
f.close()

cr.close()
conn.close()
