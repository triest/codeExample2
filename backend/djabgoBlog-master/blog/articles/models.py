from django.db import models
from django.contrib.auth.models import User;
from django.conf import settings


# Create your models here.
class Article(models.Model):
    id = models.AutoField(primary_key=True)
    title=models.CharField(max_length=30);
    description=models.TextField();
    date=models.DateTimeField(auto_now_add=True);
    #author = models.ForeignKey(User, on_delete=models.CASCADE, default=None)
    author = models.ForeignKey(User, null=True, blank=True, on_delete=models.PROTECT)
    #author = models.ForeignKey(User, blank=True, on_delete=models.PROTECT)
    #author = models.ForeignKey(User,  blank=True, null=True, on_delete=models.PROTECT)
    #author = models.ForeignKey(User, default=None, on_delete=models.PROTECT)
    #author = models.ForeignKey(User, null=True);
    #author=models.ForeignKey(User,default=None,on_delete=models.PROTECT)
    #author = models.ForeignKey(User, on_delete=models.PROTECT, default=None)﻿
    #author = models.ForeignKey(User, on_delete=models.CASCADE, default=None)
    #author = models.ForeignKey(
     #   settings.AUTH_USER_MODEL,
      #  default=1,
       # on_delete=models.CASCADE,)

    def __str__(self):
        return self.title;

    def snipped(self):
        return self.description[:50]+'...'



