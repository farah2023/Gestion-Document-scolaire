from pymongo import MongoClient

# Connection à la base de données MongoDB
connection_string = 'mongodb://localhost:27017'
client = MongoClient(connection_string)
db = client['Rentaly']

# Collection pour les administrateurs
admins_collection = db["administrators"]

# Collection pour les managers
managers_collection = db["managers"]
cars_collection = db["cars"]
factures_collection = db["factures"]
reservations_collection = db["Reservations"]
clients_collection = db["clients"]
