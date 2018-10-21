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

from django.urls import path
from django.conf.urls import url
from . import views;
from django.views.generic import (CreateView,DetailView,ListView)
from .views import ArticleListView,ArticleCreateView

app_name='articles'

urlpatterns = [

    #path('', views.article_list,name="list"),
    path('',ArticleListView.as_view(),name="list"),
    path('about', views.article_list),
   # path('<int:slug>',views.article_detail,name="detail"),
  #  path('<int:id>',views.article_detail,name="detail"),
    path('<pk>',views.DetailView.as_view(),name="detail"),
    #path('create',views.article_create,name="create"),
    path('create',ArticleCreateView.as_view(),name="create"),
    path('create2', views.article_create2, name="create2"),
    path('subscribe/<int:id>',views.sunscribe, name="subscribe"),
    path('testmail',views.testmail)
]
