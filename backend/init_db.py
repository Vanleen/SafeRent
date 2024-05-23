from app import app, db, User

# Créez un contexte d'application avant d'appeler db.create_all()
with app.app_context():
    # Créez toutes les tables
    db.create_all()

    # Optionnel : Ajoutez des utilisateurs de test
    user1 = User(email='test@example.com', password='password')
    db.session.add(user1)
    db.session.commit()

    print("Database initialized!")
