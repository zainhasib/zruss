from flask import Flask
from flask_cors import CORS, cross_origin

app = Flask(__name__)
cors = CORS(app)

# Read the file
import pandas as pd

df = pd.read_csv('./books.csv', encoding = "utf-8")
book_tags = pd.read_csv('./book_tags.csv', encoding='utf-8')
tags = pd.read_csv('./tags.csv', encoding='utf-8')

# Merge tags
tags_with_book = pd.merge(book_tags, tags, on='tag_id', how='inner') 

# Merge and group books
books_with_tags = pd.merge(df, tags_with_book, how='inner', left_on='book_id', right_on='goodreads_book_id')

import json

arr = []

df = df.fillna(0)

def get_book_by_id_from_df(id):
    book = df.loc[df['id'] == int(id)]
    print(id)
    l = book.to_dict(orient='records')
    b = json.dumps(l)
    return b



arr = df.to_dict(orient='records')
#print(jsonString)

from flask import request

popular_books =  df.sort_values(by=['average_rating'], axis=0, ascending=False, inplace=False, kind='quicksort')

@app.route('/')
def get_books():
    arr = df.to_dict(orient='records')
    jsonString = json.dumps(arr[0:8])
    return jsonString

trending_books = df.sort_values(by=['original_publication_year', 'average_rating'], axis=0, ascending=False, inplace=False, kind='quicksort')

@app.route('/trend')
def get_books_trending():
    arr = trending_books.to_dict(orient='records')
    jsonString = json.dumps(arr[0:8])
    return jsonString



def getBooksFromPages(page):
    page = int(page)
    start = page*16 - 16
    end = page*16
    dataObject = dict()
    jsonBooks = json.dumps(arr[start:end])
    dataObject['data'] = arr[start:end]
    dataObject['success'] = True
    jsonObject = json.dumps(dataObject)
    pages = len(arr)/16
    dataObject['pages'] = pages
    jsonObject = json.dumps(dataObject)
    return jsonObject


@app.route('/books')
def get_books_list():
    jsonObject = getBooksFromPages(request.args.get('page'))
    return jsonObject


@app.route('/book/<id>')
def get_book_by_id(id):
    book = get_book_by_id_from_df(id)
    return book

class Books:
    def __init__(self):
        print('Book Called')

    def get_book_by_genre(self, page, tag):
        books_with_tags.fillna(0, inplace=True)
        newDf = books_with_tags[books_with_tags['tag_name']==tag]
        page = int(page)
        start = page*16 - 16
        end = page*16
        dataObject = dict()
        arr = newDf.to_dict(orient='records')
        dataObject['data'] = arr[start:end]
        dataObject['success'] = True
        jsonObject = json.dumps(dataObject)
        pages = int(len(arr)/16)
        dataObject['pages'] = pages
        jsonObject = json.dumps(dataObject)
        return jsonObject

    def get_latest_books(self, page):
        newDf = df.sort_values(by=['original_publication_year'], axis=0, ascending=False, inplace=False, kind='quicksort')
        page = int(page)
        start = page*16 - 16
        end = page*16
        dataObject = dict()
        arr = newDf.to_dict(orient='records')
        dataObject['data'] = arr[start:end]
        dataObject['success'] = True
        jsonObject = json.dumps(dataObject)
        pages = len(arr)/16
        dataObject['pages'] = pages
        jsonObject = json.dumps(dataObject)
        return jsonObject

    def get_trending_books(self, page):
        newDf = trending_books
        page = int(page)
        start = page*16 - 16
        end = page*16
        dataObject = dict()
        arr = newDf.to_dict(orient='records')
        dataObject['data'] = arr[start:end]
        dataObject['success'] = True
        jsonObject = json.dumps(dataObject)
        pages = len(arr)/16
        dataObject['pages'] = pages
        jsonObject = json.dumps(dataObject)
        return jsonObject

    def get_popular_books(self, page):
        newDf = df.sort_values(by=['average_rating'], axis=0, ascending=False, inplace=False, kind='quicksort')
        page = int(page)
        start = page*16 - 16
        end = page*16
        dataObject = dict()
        arr = newDf.to_dict(orient='records')
        dataObject['data'] = arr[start:end]
        dataObject['success'] = True
        jsonObject = json.dumps(dataObject)
        pages = len(arr)/16
        dataObject['pages'] = pages
        jsonObject = json.dumps(dataObject)
        return jsonObject


@app.route('/books/latest')
def latest_book():
    newBooks = Books()
    jsonObject = newBooks.get_latest_books(request.args.get('page'))
    return jsonObject

@app.route('/books/trending')
def trending_book():
    newBooks = Books()
    jsonObject = newBooks.get_trending_books(request.args.get('page'))
    return jsonObject

@app.route('/books/popular')
def popular_book():
    newBooks = Books()
    jsonObject = newBooks.get_popular_books(request.args.get('page'))
    return jsonObject

@app.route('/books/genre')
def genre_book():
    newBooks = Books()
    jsonObject = newBooks.get_book_by_genre(request.args.get('page'), request.args.get('tag'))
    return jsonObject

if __name__ == '__main__':
   app.run()