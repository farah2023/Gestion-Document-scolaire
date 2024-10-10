from django.conf import settings
from django.http import HttpResponse
from django.shortcuts import render, redirect , get_object_or_404#qui va nous retourner des pages html
from django.contrib import messages

from datetime import datetime
from django.contrib.auth.decorators import login_required
from db import admins_collection, managers_collection, cars_collection, reservations_collection,clients_collection,factures_collection
from django.core.files.uploadedfile import InMemoryUploadedFile

from django.contrib.auth import logout

import os
from django.contrib.auth.hashers import check_password, make_password
from django.http import Http404
from reportlab.pdfgen import canvas

from reportlab.lib.pagesizes import letter
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.lib.units import inch
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle, Image



# Ajouter le chemin du répertoire contenant utils.py au chemin de recherche
# sys.path.append(os.path.abspath("C:\\Users\\pc\\Desktop\\Rentlay_mongo\\Rentlay\\utils.py"))

# Maintenant, vous pouvez importer admins_collection
# from utils import admins_collection, managers_collection


def home_view(request): # request sont les donnes de notre requettes
    # return HttpResponse('hello world') #ce msg qui va s'afficher au utilisateur
    return render(request, 'index.html')


def about_view(request):
    
     return render(request, 'about.html')

def contact_view(request): 
    
    return render(request, 'contact.html')
    
def cars_view(request):
    return render(request, 'cars.html')


def login_view(request): 
    
    return render(request, 'login.html')



def cnx_view(request):
    if request.method == 'POST':
        username = request.POST.get('username')
        password = request.POST.get('password')

        # Vérifier si les champs username et password sont vides
        if not username or not password:
            messages.error(request, 'Username and password are required')
            return render(request, 'login.html')

        # Vérifier si les informations de connexion correspondent à un administrateur
        admin = admins_collection.find_one({'username': username})
        if admin and check_password(password, admin.get('password')):
            return redirect('dashboard_Admin')

        # Vérifier si les informations de connexion correspondent à un manager
        manager = managers_collection.find_one({'username': username})
        if manager and check_password(password, manager.get('password')):
            return redirect('dash_manager', id=manager['id'])

        # Si les informations de connexion ne correspondent à aucun utilisateur, afficher un message d'erreur
        messages.error(request, 'Invalid username or password')

    # Si la méthode de requête n'est pas POST ou si l'authentification échoue, retourner à la page de connexion
    return render(request, 'login.html')

#ADMIN 

def dashboard_Admin_view(request): #dash_admin
    managers_list = list(managers_collection.find())
    
    col1 = cars_collection
    col2 =reservations_collection
    col3 = clients_collection
    col4 = managers_collection
    
    count_cars = col1.count_documents({})
    count_reserv = col2.count_documents({})
    count_client = col3.count_documents({})
    count_managers = col4.count_documents({})
    admin = admins_collection.find_one({'id': 1})
    admin_image = admin.get('image', None)

    context = {
        "managers_list": managers_list,
        "count_cars": count_cars,
        "count_reserv": count_reserv,
        "count_managers": count_managers,
        "count_client": count_client,
        "admin_image": admin_image,
        "admin": admin
      
    }

    if len(managers_list) == 0:
        context['no_managers'] = True

    return render(request, 'dashboard_Admin.html', context)


#ADD manager
def add_manager_view(request):
    admin = admins_collection.find_one({'id': 1})
  
    context = { "admin": admin}

    if request.method == 'POST':
        nom = request.POST.get('name')
        prenom = request.POST.get('lastname')
        username = request.POST.get('username')
        email = request.POST.get('email')
        password = request.POST.get('password')
        telephone = request.POST.get('phone')
        confirm_password = request.POST.get('re-password')

        # Vérifier si tous les champs sont remplis
        fields = [nom, prenom, username, email, password, telephone, confirm_password]
        if any(field is None or field.strip() == '' for field in fields if isinstance(field, str)):
            messages.error(request, "All fields are required.")
            return render(request, 'add_manager.html', context)

        # Convertir telephone en entier après vérification
        try:
            telephone = int(telephone)
        except ValueError:
            messages.error(request, "Invalid phone number.")
            return render(request, 'add_manager.html', context)

        if password != confirm_password:
            messages.error(request, "Password and confirm password do not match")
            return redirect('add_manager')

        if managers_collection.find_one({'username': username}):
            messages.error(request, "Username already exists")
            return redirect('add_manager')

        image_path = None
        if 'photo' in request.FILES:
            image = request.FILES['photo']
            image_path = os.path.join(settings.MEDIA_ROOT, image.name)
            with open(image_path, 'wb') as f:
                for chunk in image.chunks():
                    f.write(chunk)
            image_path = image.name  # Store relative path or adjust as needed

        max_id = managers_collection.find_one(sort=[("id", -1)])
        new_id = max_id["id"] + 1 if max_id else 1

        hashed_password = make_password(password)
        manager_data = {
            'id': new_id,
            'name': nom,
            'lastname': prenom,
            'username': username,
            'phone': telephone,
            'email': email,
            'password': hashed_password,
            'image_path': image_path
        }

        managers_collection.insert_one(manager_data)
        messages.success(request, "Manager added successfully!")
        return redirect('dashboard_Admin')

    return render(request, 'add_manager.html', context)

#DELETE MANAGER
def delete_manager_view(request, id):
    # Convertir id en int si c'est stocké comme int dans MongoDB
    result = managers_collection.delete_one({"id": int(id)})

    # Vérifier si le document a été supprimé
    if result.deleted_count > 0:
        messages.success(request, "Manager successfully deleted.")
    else:
        messages.error(request, "Failed to delete manager. Manager may not exist.")

    return redirect('dashboard_Admin')


#Update Manager

def update_manager_view(request, manager_id):
    # Recherche du manager par ID
    manager = managers_collection.find_one({'id': int(manager_id)})
    if not manager:
        messages.error(request, "Manager not found.")
        return redirect('dashboard_Admin')

    if request.method == 'POST':
        nom = request.POST.get('name')
        prenom = request.POST.get('lastname')
        username = request.POST.get('username')
        email = request.POST.get('email')
        telephone = int(request.POST.get('phone'))
        photo = request.FILES.get('photo')
        old_password = request.POST.get('old_password')
        new_password = request.POST.get('password')
        confirm_password = request.POST.get('re-password')

        if not all([nom, prenom, username, email, telephone]):
            messages.error(request, "All fields except password are required.")
            return render(request, 'update_manager.html', {'manager': manager})
        
        if old_password:
            # Vérifier si l'ancien mot de passe est correct
            if not check_password(old_password, manager.get('password')):
                messages.error(request, "Old password is incorrect.")
                return render(request, 'update_manager.html', {'manager': manager})


        if new_password and new_password != confirm_password:
            messages.error(request, "New password and confirmation do not match.")
            return render(request, 'update_manager.html', {'manager': manager})

        update_data = {
            'name': nom,
            'lastname': prenom,
            'username': username,
            'phone': telephone,
            'email': email
        }

        if new_password:
            hashed_password = make_password(new_password)
            update_data['password'] = hashed_password

        if photo:
            image_path = os.path.join(settings.MEDIA_ROOT, photo.name)
            with open(image_path, 'wb') as f:
                for chunk in photo.chunks():
                    f.write(chunk)
            update_data['image_path'] = photo.name  # or adjust as needed for the path

        managers_collection.update_one({'id': int(manager_id)}, {'$set': update_data})
        messages.success(request, "Manager updated successfully!")
        return redirect('dashboard_Admin')

    # Afficher le formulaire avec les informations existantes du manager
    return render(request, 'update_manager.html', {'manager': manager})



def signout_view(request):
    # Déconnecter l'utilisateur
    logout(request)
    # Vous pouvez ajouter un message de succès pour la déconnexion
    messages.success(request, "You have been successfully logged out.")
    # Rediriger l'utilisateur vers la page d'accueil ou la page de connexion
    return redirect('login')  # Assurez-vous que 'login' est le nom de votre URL pour la page de connexion





#MANAGERRRRRRRRRRRRRRRRR

def dash_manager_view(request, id):
    cars_list = list(cars_collection.find())
    manager = managers_collection.find_one({"id": id})
    col1 = cars_collection
    col2 =reservations_collection
    col3 = clients_collection
    col4 = managers_collection
    
    count_cars = col1.count_documents({})
    count_reserv = col2.count_documents({})
    count_client = col3.count_documents({})
    count_managers = col4.count_documents({})
    admin = admins_collection.find_one({'id': 1})
    admin_image = admin.get('image', None)

    context = {
        "count_cars": count_cars,
        "count_reserv": count_reserv,
        "count_managers": count_managers,
        "count_client": count_client,
        "admin_image": admin_image,
        "manager": manager,
        "cars_list": cars_list
    }
    return render(request, 'dashboard_manager.html' , context)

def car_details_view(request, id):
    
    cars_list = list(cars_collection.find())
    manager = managers_collection.find_one({"id": id})
    request.session['manager_id'] = id 
    
    admin = admins_collection.find_one({'id': 1})
    admin_image = admin.get('image', None)

    context = {
        "admin_image": admin_image,
        "manager": manager,
        "cars_list": cars_list
    }
    return render(request, 'cars_details.html' , context)






def add_car_view(request, id):
    manager = managers_collection.find_one({'id': id})
    if request.method == 'POST':
        # Retrieving form data
        brand = request.POST.get('brand')
        model = request.POST.get('model')
        year = int(request.POST.get('year'))
        color = request.POST.get('color')
        price = float(request.POST.get('price'))
        # image = request.FILES.get('image')  # Assuming form includes an image upload
        fuel = request.POST.get('fuel')
        km = int(request.POST.get('km'))
        code = int(request.POST.get('code'))

        # Check if the car code already exists to ensure uniqueness
        if cars_collection.find_one({'code': code}):
            messages.error(request, 'This code already exists. Please use a different code.')
            redirect('car_detaills', id=id)

        # Determine the new car_id by finding the max existing car_id and adding 1
        max_car = cars_collection.find_one(sort=[("car_id", -1)])
        new_car_id = max_car["car_id"] + 1 if max_car else 1

        if 'image' in request.FILES:
            image = request.FILES['image']
            image_path= os.path.join(settings.MEDIA_ROOT, image.name)
        with open(image_path, 'wb') as f:
            for chunk in image.chunks():
                f.write(chunk)
                image_path = image.name  # Store relative path or adjust as needed


        # Prepare car data dictionary
        car_data = {
            'car_id': new_car_id,
            'brand': brand,
            'model': model,
            'year': year,
            'color': color,
            'price': price,
            'status': 'Available',  # Default status
            'fuel': fuel,
            'km': km,
            'code': code,
            'image': image_path
        }

        # Insert new car into MongoDB
        result = cars_collection.insert_one(car_data)
        
        if result.inserted_id:
            messages.success(request, 'Car added successfully!')
            return redirect('car_detaills', id=id)  # Adjust the redirect as needed
        else:
            messages.error(request, 'Failed to add car. Please try again.')

    return render(request, 'cars_details.html', {'manager':manager})





def afficher_manager_view (request, id):
    admin = admins_collection.find_one({'id': 1})
  
    

    manager = managers_collection.find_one({"id": id})
    context={"admin": admin,
             
             "manager": manager
             }
    if manager:
        # Passez les données du gestionnaire et l'URL de l'image au contexte du template
        return render(request, 'managers.html',context )
    else:
        return HttpResponse("Manager not found")




def delete_car_view(request, id):
    # Convert id to integer if necessary
    id = int(id)  # Ensure this matches your database's data type for car_id

    # Supprimer les réservations liées à cette voiture
    reservations_result = reservations_collection.delete_many({"car_code": id})

    # Supprimer la voiture
    result = cars_collection.delete_one({"car_id": id})

    # Retrieve manager_id from session
    manager_id = request.session.get('manager_id')

    # Check if the car was successfully deleted
    if result.deleted_count > 0:
        messages.success(request, f"Car successfully deleted along with {reservations_result.deleted_count} related reservations.")
    else:
        messages.error(request, "Failed to delete car. The car may not exist.")

    # Redirect to the car details page for the manager
    return redirect('car_detaills', id=manager_id)  # Use the correct URL name and parameter

def delete_client_view(request, id):
    manager_id = request.session.get('manager_id')
    
    # Supprimer les réservations liées à ce client
    reservations_result = reservations_collection.delete_many({"customer_id": id})

    # Supprimer le client
    result = clients_collection.delete_one({"customer_id": id})

    # Check if the client was successfully deleted
    if result.deleted_count > 0:
        messages.success(request, f"Client successfully deleted along with {reservations_result.deleted_count} related reservations.")
    else:
        messages.error(request, "Failed to delete client. The client may not exist.")
        
    return redirect('clients', id=manager_id)  # Use the correct URL name and parameter



def clients_view(request, id):
    request.session['manager_id'] = id 
    # Récupérer la liste des clients depuis la base de données
    clients_list = list(clients_collection.find())
    
    # Récupérer les données du manager
    manager = managers_collection.find_one({"id": id})
    
    # Passer les données au template
    context = {
        "manager": manager,
        "clients_list": clients_list
    }
    
    # Rendre le template avec les données
    return render(request, 'clients.html', context)




def update_car_view(request, car_id ):
    
    car = cars_collection.find_one({"car_id":car_id})
    manager_id = request.session.get('manager_id')
    manager = managers_collection.find_one({"id": manager_id})
    
    # Passer les données au template
    context = {
        "manager": manager
    }
    
    if not car:
        messages.error(request, "Car not found.")
        return redirect('car_detaills', id=manager_id)

    if request.method == 'POST':
        brand = request.POST.get('brand')
        model = request.POST.get('model')
        year = int(request.POST.get('year'))
        color = request.POST.get('color')
        price = float(request.POST.get('price'))
        status = request.POST.get('status')
        fuel = request.POST.get('fuel')
        km = int(request.POST.get('km'))
        code= int(request.POST.get('code'))
        image = request.FILES.get('image') if 'image' in request.FILES else None

        update_data = {
            'brand': brand,
            'model': model,
            'year': year,
            'color': color,
            'price': price,
            'status': status,
            'fuel': fuel,
            'km': km,
            'code': code,
        }

        if image:
            image_path = os.path.join(settings.MEDIA_ROOT, image.name)
            with open(image_path, 'wb') as f:
                for chunk in image.chunks():
                    f.write(chunk)
            update_data['image'] = image.name  # or adjust as needed for the path

        cars_collection.update_one({'car_id': int(car_id)}, {'$set': update_data})
        messages.success(request, "Car updated successfully!")
        return redirect('car_detaills', id=manager_id)
     
    return render(request, 'car_details.html' ,context )

def update_client_view(request, id_customer):
    client = clients_collection.find_one({"customer_id": id_customer})
    manager_id = request.session.get('manager_id')
    manager = managers_collection.find_one({"id": manager_id})

    if not client:
        messages.error(request, "Client not found.")
        return redirect('clients', id=manager_id)

    if request.method == 'POST':
        update_data = {
            'name': request.POST.get('name'),
            'lastname': request.POST.get('lastname'),
            'email': request.POST.get('email'),
            'phone': int(request.POST.get('phone')),
            'CIN': request.POST.get('cin'),
            'adresse': request.POST.get('adresse'),
        }

        # Update in the correct collection: clients_collection
        clients_collection.update_one({'customer_id': int(id_customer)}, {'$set': update_data})
        messages.success(request, "Client updated successfully!")
        return redirect('clients', id=manager_id)

    # Prepare context with manager and client data for the template
    context = {
        "manager": manager,
        "client": client
    }
    return render(request, 'clients.html', context)




def car_view(request, id):
   
    car_details = cars_collection.find_one({"car_id": id})
    manager_id = request.session.get('manager_id')
    manager = managers_collection.find_one({"id": manager_id})
    
    # Passer les données au template
    context = {
        "manager": manager,
         "car": car_details
    }

    if not car_details:
         return HttpResponse("Car not found")

    
    return render(request, "update_car.html", context)

def client_view(request, id):
    client_details = clients_collection.find_one({"customer_id": id})
    manager_id = request.session.get('manager_id')
    manager = managers_collection.find_one({"id": manager_id})
    
    # Passer les données au template
    context = {
        "manager": manager,
        "client": client_details
    }
    if not client_details:
         return HttpResponse("Client not found")
     
    return render(request, "update_client.html", context)


def reserv_view(request, id):
    # Tentez de trouver le manager avec l'ID donné
    manager = managers_collection.find_one({'id': id})
    request.session['manager_id'] = id 
    
    if not manager:
        raise Http404("Manager not found with the ID")

    res_col = reservations_collection.find({"rejection_reason": None})

    res_data = list(res_col)

    # Ajouter des détails sur les voitures et les clients à chaque réservation
    for reservation in res_data:
        # Ajouter des détails de la voiture
        car = cars_collection.find_one({'code': reservation['car_code']})
        reservation['car_details'] = {
            'brand': car['brand'] if car else ' not available',
            'model': car['model'] if car else 'not available',
            'code': car['code'] if car else 'not available'
        }
        
        # Ajouter des détails du client
        customer = clients_collection.find_one({'customer_id': reservation['customer_id']})
        reservation['customer_details'] = {
            'name': customer['name'] if customer else ' not available',
            'phone': customer['phone'] if customer else ' not available'
        }

    context = {
        "reservations": res_data,
        "manager": manager  # Pass the manager's details to the template
    }
    
  

    return render(request, "reservations.html", context)




def add_client_view(request, id):
    manager = managers_collection.find_one({'id': id})
    if request.method == 'POST':
        name = request.POST.get('name')
        lastname = request.POST.get('lastname')
        email = request.POST.get('email')
        phone =int(request.POST.get('phone'))
        cin = request.POST.get('CIN')
        address = request.POST.get('adresse')
        new_id = None
         # Vérification de l'unicité de l'email et du CIN
        if clients_collection.find_one({'email': email}):
            messages.error(request, 'Email already exists. Please use a different email.')
            return redirect('clients', id=manager['id'])
            
        elif clients_collection.find_one({'CIN': cin}):
            messages.error(request, 'CIN already exists. Please use a different CIN.')
            return redirect('clients', id=manager['id'])
        else:
            max_id = clients_collection.find_one(sort=[("customer_id", -1)])
            new_id = max_id["customer_id"] + 1 if max_id else 1

        client_data = {
            'customer_id': new_id,
            'name': name,
            'lastname': lastname,
            'email': email,
            'phone': phone,
            'CIN': cin,
            'adresse': address
        }
    
        # Insertion des données du client dans la collection MongoDB
        result = clients_collection.insert_one(client_data)
        
        if result.inserted_id:
            messages.success(request, 'Client added successfully!')
            # Rediriger vers la liste des clients après l'ajout en passant seulement l'id du manager
            return redirect('clients', id=manager['id'])
        else:
            messages.error(request, 'Failed to add client. Please try again.')
    
    return render(request, 'clients.html', id=manager['id'])



from datetime import datetime
from django.shortcuts import redirect, render
from django.contrib import messages

def add_res_view(request, id):
    manager = managers_collection.find_one({'id': id})
    if request.method == 'POST':
        try:
            # Convert car_code and customer_id to integers
            car_code = int(request.POST.get('car_code'))
            customer_id = int(request.POST.get('customer_id'))
        except ValueError:
            messages.error(request, 'Car code and Customer ID must be numeric.')
            return redirect('reservations', id=manager['id'])

        # Validate existence in the database
        car_exists = cars_collection.find_one({'code': car_code})
        customer_exists = clients_collection.find_one({'customer_id': customer_id})
        if not car_exists or not customer_exists:
            messages.error(request, 'Car or Customer does not exist.')
            return redirect('reservations', id=manager['id'])

        # Check if the car is available
        if car_exists.get('status') != 'Available':
            messages.error(request, 'The car is not available for reservation.')
            return redirect('reservations', id=manager['id'])

        start_date = request.POST.get('start_date')
        end_date = request.POST.get('end_date')
        price = float(request.POST.get('price'))

        # Check for existing reservations for the same car within the date range
        if reservations_collection.find_one({'car_code': car_code, 'status': 'not available', 
                                             'start_date': {'$lte': end_date}, 'end_date': {'$gte': start_date}}):
            messages.error(request, 'Car already reserved for the given dates. Please choose another date or car.')
            return redirect('reservations', id=manager['id'])

        max_id = reservations_collection.find_one(sort=[("reservation_id", -1)])
        new_id = max_id["reservation_id"] + 1 if max_id else 1

        reservation_data = {
            'reservation_id': new_id,
            'car_code': car_code,
            'customer_id': customer_id,
            'start_date': start_date,
            'end_date': end_date,
            'price': price,
            'status': ' ',
            'rejection_reason': None
        }

        # Insertion des données de la réservation dans la collection MongoDB
        result = reservations_collection.insert_one(reservation_data)

        if result.inserted_id:
            messages.success(request, 'Reservation added successfully!')
            return redirect('reservations', id=manager['id'])  # Ensure you have a 'reservations' view to redirect to
        else:
            messages.error(request, 'Failed to add reservation. Please try again.')

    return render(request, 'reservations.html', {'id': manager['id']})


#install pip install reportlab
from datetime import datetime
from django.shortcuts import redirect
from django.contrib import messages

def accept_reservation(request, reservation_id):
    # Convert reservation_id to integer if necessary
    reservation_id = int(reservation_id)
    reservation = reservations_collection.find_one({'reservation_id': reservation_id})
    manager_id = request.session.get('manager_id')

    if not reservation:
        messages.error(request, "Reservation not found.")
        return redirect('reservations', id=manager_id)  # Adjust redirect as per your URL configuration

    # Check if the reservation is already accepted
    if reservation.get('status') == 'accepted':
        # Find the associated invoice to generate the PDF
        facture = factures_collection.find_one({'reservation_id': reservation_id})
        if facture:
            return generate_pdf(request, reservation_id, facture['facture_id'])
        else:
            messages.error(request, "Invoice not found, but reservation is marked as accepted.")
            return redirect('reservations', id=manager_id)

    # Update reservation status to 'accepted'
    reservations_collection.update_one(
        {'reservation_id': reservation_id},
        {'$set': {'status': 'accepted'}}
    )

    # Update the car status based on reservation dates
    car_code = reservation.get('car_code')
    current_date = datetime.now()

    # Convert date strings to datetime objects if they are strings
    reservation_start_date = reservation.get('start_date')
    reservation_end_date = reservation.get('end_date')

    if isinstance(reservation_start_date, str):
        reservation_start_date = datetime.strptime(reservation_start_date, '%Y-%m-%d')
    
    if isinstance(reservation_end_date, str):
        reservation_end_date = datetime.strptime(reservation_end_date, '%Y-%m-%d')

    # Update the car status based on the current date and reservation dates
    if reservation_start_date <= current_date <= reservation_end_date:
        cars_collection.update_one(
            {'code': car_code},
            {'$set': {'status': 'non available'}}
        )
    else:
        cars_collection.update_one(
            {'code': car_code},
            {'$set': {'status': 'Available'}}
        )

    # Get the next invoice ID
    max_facture = factures_collection.find_one(sort=[("facture_id", -1)])
    new_facture_id = max_facture["facture_id"] + 1 if max_facture else 1

    # Insert an invoice record
    facture_data = {
        'facture_id': new_facture_id,
        'reservation_id': reservation_id,
        'facture_date': datetime.now(),
        'status': 'Paid'
    }
    result = factures_collection.insert_one(facture_data)

    # Ensure the invoice is created successfully
    if not result.inserted_id:
        messages.error(request, 'Failed to create invoice.')
        return redirect('reservations', id=manager_id)

    # Generate PDF for the new invoice
    return generate_pdf(request, reservation_id, new_facture_id)





def generate_pdf(request, reservation_id, facture_id):
    response = HttpResponse(content_type='application/pdf')
    response['Content-Disposition'] = f'attachment; filename="invoice_{reservation_id}.pdf"'
    doc = SimpleDocTemplate(response, pagesize=letter, rightMargin=72, leftMargin=62, topMargin=32, bottomMargin=58)
    Story = []
    styles = getSampleStyleSheet()
    styles.add(ParagraphStyle('BlueTitle', parent=styles['Title'], textColor=colors.blue))
    styles.add(ParagraphStyle('Justify', alignment=1))

    # Load the logo image
    logo_path = os.path.join('static', 'images', 'logo.png')
    logo = Image(logo_path)
    logo.drawHeight = 1 * inch
    logo.drawWidth = 2 * inch

    # Retrieve facture details
    facture = factures_collection.find_one({'facture_id': facture_id})
    if not facture:
        print("Facture details not found.")  # Handle error appropriately
        return response

    # Header with Invoice ID and Date
    invoice_title = Paragraph(f'Reservation Invoice #{facture_id}', styles['Title'])
    invoice_date = Paragraph(f'Date: {facture["facture_date"].strftime("%Y-%m-%d")}')

    data = [[logo, invoice_title, invoice_date]]
    table = Table(data, colWidths=[2*inch, 3*inch, 2*inch])
    table.setStyle(TableStyle([
        ('ALIGN', (0,0), (-1,-0.5), 'CENTER'),
        ('VALIGN', (0,0), (-5,-5), 'TOP'),
        ('TEXTCOLOR', (1,0), (1,0), colors.blue),
        ('FONTSIZE', (1,0), (1,0), 14),
    ]))
    Story.append(table)
    Story.append(Spacer(10,80))

    # Reservation and Customer Details
    reservation = reservations_collection.find_one({'reservation_id': reservation_id})
    car = cars_collection.find_one({'code': reservation['car_code']})
    client =clients_collection.find_one({'customer_id': reservation['customer_id']})

    # Reservation Details Table
    data = [
        ['Car Brand', 'Car Model', 'Customer Name', 'Start Date', 'End Date', 'Total Price'],
        [car['brand'], car['model'], client['name'], reservation['start_date'], reservation['end_date'], f"DH {reservation['price']}"]
    ]
    details_table = Table(data, colWidths=[1.5*inch] * 6)
    details_table.setStyle(TableStyle([
        ('GRID', (0,0), (-1,-1), 1, colors.black),
        ('BACKGROUND', (0,0), (-1,0), colors.lightblue),
        ('ALIGN', (0,0), (-1,-1), 'CENTER')
    ]))
    Story.append(details_table)
    Story.append(Spacer(1, 24))

    # Footer
    Story.append(Paragraph("Thank you for your business!", styles['Justify']))
    Story.append(Spacer(1, 12))
    footer_text = f'If you have any questions about this invoice, please contact us at {"Rentlayt@gmail.com"}'
    Story.append(Paragraph(footer_text, styles['Justify']))

    doc.build(Story)
    return response



def reject_reservation(request, reservation_id):
    manager_id = request.session.get('manager_id')
    if request.method == 'POST':
        rejection_reason = request.POST.get('rejection_reason')
        
        # Fetch the reservation to ensure it exists
        reservation = reservations_collection.find_one({'reservation_id': reservation_id})
        if not reservation:
            messages.error(request, "Reservation not found.")
            return redirect('reservations', id= manager_id)  # Adjust redirect as per your URL configuration

        # Update the reservation with rejection status and reason
        result = reservations_collection.update_one(
            {'reservation_id': reservation_id},
            {'$set': {'status': 'rejected', 'rejection_reason': rejection_reason}}
        )

        if result.modified_count > 0:
            messages.success(request, "Reservation successfully rejected.")
        else:
            messages.error(request, "Failed to reject reservation.")
        
        return redirect('reservations', id= manager_id)   # Redirect to reservation list or appropriate page

    # If not POST, render the form or redirect
    return render(request, 'reservations.html',  id= manager_id )