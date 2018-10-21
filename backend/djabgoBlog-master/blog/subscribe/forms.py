from django.contrib.auth.decorators import login_required
from django.shortcuts import render
from inspect import getmembers
from pprint import pprint
from django.forms import modelform_factory
from django import forms
from django.contrib.auth.models import User;
from . import models
#from blog.articles.models import Subscribe as Subscribe1

class SunscribeForm(forms.ModelForm):
    class Meta:
        model = models.Subscribe
        fields = ['name']



