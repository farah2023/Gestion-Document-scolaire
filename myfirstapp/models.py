# Aucun modèle de classe n'est nécessaire avec PyMongo,
# vous travaillerez directement avec des dictionnaires.

# Create your models here.
from django.db import models
import datetime
import os 


from django.db import models

class Car(models.Model):
    id = models.AutoField(primary_key=True)
    brand = models.CharField(max_length=100)
    model = models.CharField(max_length=100)
    year = models.IntegerField()
    color = models.CharField(max_length=50)
    price = models.DecimalField(max_digits=10, decimal_places=2)
    image = models.CharField(max_length=255, blank=True)
    status = models.CharField(max_length=20, choices=[('Available', 'Available'), ('Unavailable', 'Unavailable')], default='Available')
    fuel = models.CharField(max_length=255, blank=True)
    kilometer =models.IntegerField()
    def __str__(self):
        return f"{self.brand} {self.model} - {self.year}"


class Reservation(models.Model):
    car = models.ForeignKey(Car, on_delete=models.CASCADE)
    client_name = models.CharField(max_length=100)
    reservation_date = models.DateField(auto_now_add=True)
    manager = models.ForeignKey('Manager', on_delete=models.SET_NULL, null=True)
    status_choices = [
        ('Pending', 'Pending'),
        ('Accepted', 'Accepted'),
        ('Rejected', 'Rejected'),
    ]
    status = models.CharField(max_length=20, choices=status_choices, default='Pending')

    def __str__(self):
        return f"Reservation for {self.car} by {self.client_name}"

class Client(models.Model):
    name = models.CharField(max_length=100)
    email = models.EmailField()
    phone = models.CharField(max_length=15)

    def __str__(self):
        return self.name
    
class Manager(models.Model):
    id = models.AutoField(primary_key=True)
    name = models.CharField(max_length=100)
    lastname = models.CharField(max_length=100)
    username = models.CharField(max_length=100)
    phone = models.CharField(max_length=20)
    email = models.EmailField()
    password = models.CharField(max_length=100)
    type = models.CharField(max_length=1, default='0')
    # image_path= models.ImageField(upload_to='images/')
    image_path = models.CharField(max_length=255, blank=True)

    def __str__(self):
        return self.username

class Administrator(models.Model):
    id = models.AutoField(primary_key=True)
    username = models.CharField(max_length=100, unique=True)
    password = models.CharField(max_length=100)
    # image= models.CharField(max_length=255, blank=True)
    # You should consider using Django's built-in authentication system instead of storing passwords directly

    def __str__(self):
        return self.username
