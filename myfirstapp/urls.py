
from django.contrib import admin
from django.urls import path
from . import views  #importer le model views
from django.conf.urls.static import static
from django.conf import settings

urlpatterns = [
    # path('admin/', admin.site.urls),#le 2eme parametre de cette fonctionest une function qui va s'executer lors l'acces a la page admin
    path('',views.home_view , name='home'),#quand on va acceder au page principale 
    path('login',views.login_view , name='login'),
    path('about',views.about_view , name='about'),
    path('cars',views.cars_view , name='cars'),
    path('dash_manager/<int:id>/',views.dash_manager_view , name='dash_manager'),
    path('reservations/<int:id>/', views.reserv_view, name='reservations'),
    path('add_reservation/<int:id>/', views.add_res_view, name='add_reservation'),
    path('accept_reservation/<int:reservation_id>/', views.accept_reservation, name='accept_reservation'),
    path('reject_reservation/<int:reservation_id>/', views.reject_reservation, name='reject_reservation'),


    # path('dashboard_admin.html/',views.dashboard_view, name='dashboard'),
    path('login/cnx/', views.cnx_view, name='cnx'),
    path('myprofile', views.cnx_view, name='myprofile'),
    
    path('add_manager', views.add_manager_view, name='add_manager'),
    path('contact', views.contact_view, name='contact'),
    path('dashboard_Admin', views.dashboard_Admin_view, name='dashboard_Admin'),
    path('car_detaills/<int:id>', views.car_details_view, name="car_detaills"),
    path('signout/', views.signout_view, name='signout'),
    path('clients/<int:id>/', views.clients_view, name='clients'),
    path('add_client/<int:id>/', views.add_client_view, name='add_client'),
    path('delete_manager/<int:id>/', views.delete_manager_view, name='delete_manager'),
    path('delete_car/<int:id>/', views.delete_car_view, name='delete_car'),
    path('delete_client/<int:id>/', views.delete_client_view, name='delete_client'),
    path('show_manager/<int:id>/', views.afficher_manager_view, name='show_manager'),
    path('update_car/<int:car_id>/', views.update_car_view, name='update_car'),
    path('update_client/<int:id_customer>/', views.update_client_view, name='update_client'),
    path('car/<int:id>/', views.car_view, name="car"),
    path('show_client/<int:id>/', views.client_view, name="show_client"),
    path('add_car/<int:id>/', views.add_car_view, name='add_car'),  # URL for adding a car



    path('update_manager/<int:manager_id>/', views.update_manager_view, name='update_manager'),

    

]
urlpatterns += static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)
