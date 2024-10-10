from db import cars_collection,clients_collection,managers_collection,admins_collection,reservations_collection,factures_collection
from db import db
import os
import django
from django.conf import settings

settings.configure(
    DEBUG=True,
    SECRET_KEY='votre_cle_secrete_très_sécurisée',
    INSTALLED_APPS=[
        'django.contrib.auth',
        'django.contrib.contenttypes',
        'django.contrib.admin',
    ],
    PASSWORD_HASHERS=[
        'django.contrib.auth.hashers.Argon2PasswordHasher',
        'django.contrib.auth.hashers.PBKDF2PasswordHasher',
        'django.contrib.auth.hashers.PBKDF2SHA1PasswordHasher',
        'django.contrib.auth.hashers.BCryptSHA256PasswordHasher',
    ],
)

django.setup()

# Après cette configuration, vous pouvez utiliser make_password
from django.contrib.auth.hashers import make_password

# # Créer un index unique pour le champ 'customer_id' dans la collection 'customers'
# db.clients.create_index("customer_id", unique=True)

# # Créer un index unique pour le champ 'car_id' dans la collection 'cars'
# db.cars.create_index("car_id", unique=True)

# # Créer un index unique pour le champ 'reservation_id' dans la collection 'reservations'
# db.reservations.create_index("reservation_id", unique=True)

# # Données de la voiture à ajouter

# Données de l'administrateur à ajouter

# Votre code pour interagir avec MongoDB ici
#  il faut installer "pip install argon2-cffi " pour que le hasahge marchera

admin_data = {
    'id': 1,
    'username': "admin1",
    'password': make_password("password1"),  # Hachage du mot de passe
    'image': "2.jpg",
    'email': "admin@gmail.com"
}

# Insertion de l'administrateur dans la collection
result = admins_collection.insert_one(admin_data)
print("Admin ajouté avec l'ID :", result.inserted_id)


