from flask import Blueprint, request, jsonify
from app import db
from models import User
import jwt
import datetime

auth_bp = Blueprint('auth', __name__)

@auth_bp.route('/forgot-password', methods=['POST'])
def forgot_password():
    data = request.get_json()
    email = data['email']
    user = User.query.filter_by(email=email).first()
    
    if user:
        token = jwt.encode({
            'user_id': user.id,
            'exp': datetime.datetime.utcnow() + datetime.timedelta(minutes=30)
        }, 'your_secret_key', algorithm='HS256')
        
        # Envoyer l'email avec le token ici (code omis pour la simplicité)
        return jsonify({'message': 'Email sent with reset instructions.'})
    
    return jsonify({'message': 'Email not found.'}), 404
