from flask import Flask, request
from flask_cors import CORS
from pymongo import MongoClient
from passlib.hash import sha256_crypt
import json
from bson.objectid import ObjectId

app = Flask(__name__)
CORS(app)

client = MongoClient('localhost', 27017)

db = client['book_db']
users = db['users']

'''
    **********  User Schema ************
    Name
    Email
    Password
    Username
    likedGenre
    readBooks
    tasteCalculated
'''


@app.route('/user/register', methods=['POST'])
def register():
    print(request.get_json())
    if request.method == 'POST':
        print(request)
        name = request.get_json().get('name')
        username = request.get_json().get('username')
        email = request.get_json().get('email')
        password = request.get_json().get('password')
        liked_genre = []
        read_books = []
        already_user = users.find_one({"username": username})
        if already_user:
            response = {
                "success": False,
                "message": "Username already taken",
                "data": ""
            }
            return json.dumps(response)
        already_user = users.find_one({"email": email})
        if already_user:
            response = {
                "success": False,
                "message": "Email already taken",
                "data": ""
            }
            return json.dumps(response)
        user = {
            "name": name,
            "username": username,
            "email": email,
            "password": sha256_crypt.encrypt(password),
            "likedGenre": liked_genre,
            "readBooks": read_books,
            "tasteCalculated": False
        }
        user_id = users.insert_one(user).inserted_id
        if user_id:
            user_data = {
                "id": str(user_id),
                "name": name,
                "username": username,
                "email": email,
                "likedGenre": liked_genre,
                "readBooks": read_books,
                "tasteCalculated": False
            }
            response = {
                "success": True,
                "message": "Registration Complete",
                "data": user_data
            }
            return json.dumps(response)
        else:
            response = {
                "success": False,
                "message": "Server error : unable to register"
            }
            return json.dumps(response)


@app.route('/user/authenticate', methods=['POST'])
def authenticate():
    if request.method == 'POST':
        username = request.get_json().get('username')
        password = request.get_json().get('password')
        found_user = users.find_one({"username": username})
        if found_user:
            if sha256_crypt.verify(password, found_user['password']):
                user = found_user
                if user:
                    user_data = {
                        "id": str(found_user['_id']),
                        "name": user['name'],
                        "username": user['username'],
                        "email": user['email'],
                        "likedGenre": user['likedGenre'],
                        "readBooks": user['readBooks'],
                        "tasteCalculated": user['tasteCalculated']
                    }
                    response = {
                        "success": True,
                        "message": "Authentication Successful",
                        "data": user_data
                    }
                    return json.dumps(response)
            else:
                response = {
                    "success": False,
                    "message": "User Authentication Unsuccessful",
                    "data": ""
                }
                return json.dumps(response)
        else:
            response = {
                "success": False,
                "message": "User not found",
                "data": ""
            }
            return json.dumps(response)


@app.route('/user/details/<user_id>', methods=['POST'])
def get_details(user_id):
    if request.method == 'POST':
        obj_id = ObjectId(user_id)
        user = users.find_one({"_id": obj_id})
        if user:
            user_data = {
                "id": user_id,
                "name": user['name'],
                "username": user['username'],
                "email": user['email'],
                "likedGenre": user['likedGenre'],
                "readBooks": user['readBooks'],
                "tasteCalculated": user['tasteCalculated']
            }
            response = {
                "success": True,
                "message": "Details Found",
                "data": user_data
            }
            return json.dumps(response)


@app.route('/user/update/taste/<user_id>', methods=['POST'])
def update_taste(user_id):
    if request.method == 'POST':
        obj_id = ObjectId(user_id)
        liked_genre = request.get_json().get('likedGenre')
        print(liked_genre)
        result = users.update_one({
            '_id': obj_id
        }, {
            '$set': {
                'tasteCalculated': True,
                'likedGenre': liked_genre
            }
        }, upsert=False)

        if result.acknowledged:
            return json.dumps(True)
        else:
            return json.dumps(False)


if __name__ == '__main__':
    app.run(port=5002, debug=True)
