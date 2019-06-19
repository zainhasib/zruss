from flask import Flask, request
from flask_cors import CORS, cross_origin

app = Flask(__name__)
cors = CORS(app)


@app.route('/api/trending')
def get_trending():
    return 'Trending'


@app.route('/api/popular')
def get_popular():
    return 'Popular'


@app.route('/api/recommended')
def get_recommended():
    return 'Recommended'


@app.route('/api/books')
def get_books():
    return 'Books'


@app.route('/api/books/<int:book_id>')
def get_book_by_id(book_id):
    return book_id


@app.route('/api/books/<book_author>')
def get_book_by_author(book_author):
    return book_author


@app.route('/api/books/<genre>')
def get_book_by_genre(genre):
    return genre

