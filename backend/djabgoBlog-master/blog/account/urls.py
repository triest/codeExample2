from django.urls import path
from django.conf.urls import url
from . import views;
from django.contrib.auth import login,authenticate
from django.contrib import auth

app_name='accounts'

urlpatterns = [
    path('singup', views.singup_view,name="singup"),
    path('login', views.login_view, name="login"),
    path('logout',views.logout_view,name="logout")
 #   path('login', views.login_view,name="singup"),

]
