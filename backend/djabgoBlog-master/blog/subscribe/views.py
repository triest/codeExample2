from django.contrib.auth.decorators import login_required
from django.shortcuts import render, get_object_or_404
from inspect import getmembers
from pprint import pprint
from .models import Subscribe
from django.forms import modelform_factory
from .models import Subscribe
from .models import Read
from . import forms
from django.contrib.auth.models import User;
from articles.models import Article
from django.views.generic import (CreateView,DetailView,ListView)
# Create your views here.
@login_required(login_url="/account/login")
def main(request):
    current_user = request.user
    #получаем инстанс subscribe авторизованного пользователя
    list=get_articles_by_subscribe(request,current_user)
    type = 'Полная лента'
    return render(request,'test.html',{'articles':list,'type':type})

class SubscribeAllViews(ListView):
   template_name = 'test.html'
   def get_queryset(self):
        return get_articles_by_subscribe(self.request,self.request.user)




#возврщает список статей по подписке
def get_articles_by_subscribe(request,current_user):
    try:
        subscribe = Subscribe.objects.get(owner=current_user)
    except:
        return render(request, 'error.html')
    users = subscribe.subscription.all()
    articles = Article.objects.all().order_by('-date')
    # теперь фильтруем
    list = [x for x in articles if x.author in users]
    return list



@login_required(login_url="/account/login")
def article_detail(request,id):
    article=Article.objects.get(pk=id)
    # тут будет проверка на то, подписан ли, по

    answer = "sub"
    try:
        sunscribe = Subscribe.objects.get(owner=request.user, sunscribe=article.author);
    except:
        answer = "not_sub"


    return render(request,'detail.html',{'article':article,'answer':answer})

@login_required(login_url="/account/login")
def mark_readed(request,id):
    #id -идентификатор статьи
    user =request.user # подписант
    try:
        reader1 = Read.objects.get(name='test',owner_reader=request.user)  #проверяем, есть ли обьект
    except Read.DoesNotExist:
        reader1 = Read.objects.create(name='test',owner_reader=request.user)
    #добавляем пост в прочитанные
    article = Article.objects.get(pk=id)
    reader1.articles_readed.add(article);
    reader1.save();
    return main(request)


#список нерочитанных
@login_required(login_url="/account/login")
def unreaded(request):
     user=request.user # подписант
     try:
         readed = Read.objects.get(owner_reader=user) #все прочитанные
     except:
         list_unreadeds = []
         return render(request, 'test.html', {'articles': list_unreadeds})
     list_unreadeds = []
     try:
        list_readed = readed.articles_readed.all();
     except:
         return render(request, 'test.html', {'articles': list_unreadeds})
     list_subscribe = get_articles_by_subscribe(readed,user) #по подписк
     list_unreadeds=[x for x in list_subscribe if x not in list_readed]
     type='Не прочитанные посты'
     return render(request,'test.html',{'articles':list_unreadeds,'type':type})

#список прочитанных
@login_required(login_url="/account/login")
def readed(request):
    user = request.user  # подписант
   # list_readed = get_articles_by_subscribe(request, user)
    try:
        readed=Read.objects.get(owner_reader=user)
    except:
        list_readed=[]
        return render(request, 'test.html', {'articles': list_readed})

    list_readed=readed.articles_readed.all();
    type='Прочитанные посты'

    return render(request, 'test.html', { 'articles': list_readed,'type':type})