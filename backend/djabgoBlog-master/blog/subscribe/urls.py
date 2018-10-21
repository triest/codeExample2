"""blog URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/2.1/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
from django.conf.urls import url,include
from . import views;
from django.views.generic import (CreateView,DetailView,ListView)
from .views import SubscribeAllViews

app_name='subscribe'

urlpatterns = [
   # path('', views.main, name='main'),
    path('',SubscribeAllViews.as_view(),name='main'),
    path('<int:id>', views.article_detail, name="detailsub"),
    path('readed/<int:id>', views.mark_readed, name="readed"),
    path('readed2', views.readed, name="readed2"),
    path('unreaded', views.unreaded, name="unreaded"),
]
