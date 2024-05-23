from app import db
import datetime

class User(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    email = db.Column(db.String(120), unique=True, nullable=False)
    password = db.Column(db.String(60), nullable=False)
    reset_token = db.Column(db.String(120), nullable=True)
    reset_token_expiration = db.Column(db.DateTime, nullable=True)
    otp = db.Column(db.Integer, nullable=True)
    otp_expiration = db.Column(db.DateTime, nullable=True)
