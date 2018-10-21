from multiprocessing import managers

from django.db import models
from django.contrib.auth.models import User;
from articles.models import Article

# Create your models here.
class Subscribe(models.Model):
   class Meta:
    verbose_name_plural = 'sunscribes'

   id=models.AutoField(primary_key=True)
   name=models.CharField(max_length=30,null=False);
  # subscribed_user=models.OneToOneField(User, on_delete=models.PROTECT)# владелец
   owner=models.ForeignKey(User,related_name='owner', null=False, blank=True, on_delete=models.PROTECT)# владелец подписки
   subscription = models.ManyToManyField(User,null=True,related_name='subscription') #те, на кого он пдписалса






class Read(models.Model):
   class Meta:
    verbose_name_plural = 'reads'

   id=models.AutoField(primary_key=True);
   name = models.CharField(max_length=30, null=True);
   owner_reader = models.ForeignKey(User, related_name='owner_reader', null=False, blank=True,on_delete=models.PROTECT)  # тот, кто прочитал
   articles_readed = models.ManyToManyField(Article, null=False, related_name='articles_readed')  # те, на кого он пдписалса

