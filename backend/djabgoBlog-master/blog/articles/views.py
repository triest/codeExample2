from django.contrib.auth.models import User
from django.shortcuts import render, redirect
from django.http import HttpResponse


from .models import Article
from django.contrib.auth.decorators import login_required
from subscribe.models import Subscribe;
from . import forms
from django.db.models.signals import post_save
from django.dispatch import receiver
from django.core.mail import send_mail
# get_template is what we need for loading up the template for parsing.
from django.template.loader import get_template
from django.template import loader
# Templates in Django need a "Context" to parse with, so we'll borrow this.
# "Context"'s are really nothing more than a generic dict wrapped up in a
# neat little function call.
from django.template import Context
from django.views.generic import (CreateView,DetailView,ListView)
#app_name='articles'
from django.views.generic import (CreateView,DetailView,ListView)
from  .forms import CreateArticle



def article_list(request):
    articles=Article.objects.all().order_by('-date')
    return render(request,"articles/article_list.html",{'articles':articles})

class ArticleCreateView(CreateView):
    template_name = 'articles/article_create.html';
    form_class = CreateArticle;
    queryset = Article.objects.all()

    def form_valid(self, form):
        article=Article.object.create_article(
            title=form.cleaned_data['title'],
            description=form.cleaned_data['description'],
            author=self.request.user
        )
        return super().form_valid(form)
        #instance.save()

class ArticleListView(ListView):
    template_name='articles/article_list.html'
    #queryset = Article.objects.all().order_by('-date')

    def get_queryset(self):
        return Article.objects.all().order_by('-date')

class DetailView(DetailView):
    model=Article;
    template_name = 'articles/detail.html'

def article_detail(request,id):
    article=Article.objects.get(pk=id)
    # тут будет проверка на то, подписан ли, по

    answer = "sub"
    try:
        sunscribe = Subscribe.objects.get(owner=request.user, sunscribe=article.author);
    except:
        answer = "not_sub"



    return render(request,'articles/detail.html',{'article':article,'answer':answer})
    #return HttpResponse(pk)

@login_required(login_url="/account/login")
def article_create(request):
    if request.method=='POST':
        form=forms.CreateArticle(request.POST,)
        if form.is_valid():
            instance=form.save(commit=True)
            instance.author=request.user
            instance.save()
            return article_list(request)
          #  return redirect('articles:list')
    else:
        form=forms.CreateArticle()
    return render(request,'articles/article_create.html',{'form':form})

def article_create2(request):
    form = forms.CreateArticle()
    if request.method == 'POST':
        form = forms.CreateArticle(request.POST, )
        if form.is_valid():
            instance =form.save(commit=True)
            instance.author=request.user
            instance.save()
            article_list(request)

    else:
        form = forms.CreateArticle()

    return render(request, 'articles/article_create2.html', {'form': form})





@login_required(login_url="/account/login")
def sunscribe(request,id):
    user=User.objects.get(pk=id) #article author
    try:
        sunscribe1=Subscribe.objects.get(owner=request.user)
    except Subscribe.DoesNotExist:
        sunscribe1 = Subscribe.objects.create(name='something', owner=request.user)
    sunscribe1.subscription.add(user)
    sunscribe1.save();
    # получаем статью по id

    return article_list(request);
   # print("ok");
   # return articl
# e_list(request)


#сигнал для отправки сообщений при добавлении поста пользоватеем (или через админку)

@receiver(post_save, sender=Article) #при добавлении статьи
def handle_new_job(sender, **kwargs):
    post = kwargs.get('instance') ; #пост, который добавили
    avtor=post.author # автор поста
    #теперь надо получить подписки, где в подписанных значиться автор
   # subscribe=Subscribe.objects.get(avtor in Subscribe.subscription ) # список подписок, где есть этот автор  КОСЯК ТУТ
    subscribe=avtor.subscription.all(); # список подписок, где есть этот автор  КОСЯК ТУТ
    # фильтруем маийлы владельцев подписок
   # email_list=subscribe.owner.mail in subscribe
    email_list=[o.owner.email for o in subscribe]  #список mail владельцев
 #   email_list=['triest21@gmail.com']
    testmail(email_list,avtor,post)
    #for item in sunscribe:
     #   user=sunscribe.owner;
      #  send_mail(
       #     'New article',
        #    'Message.',
        #    'from@example.com',
        #    ['john@example.com', 'jane@example.com'],
       # )


def testmail(recipient_list,author,Article):
  #  post = kwargs.get('instance');  # пост, который добавили
  #  avtor = post.author  # автор поста
    # теперь надо получить подписки, где в подписанных знач
   # subscribe = Subscribe.objects.get(avtor in 'subscription')  # список подписок, где есть этот автор

    # теперь в цикле обходим выбранные подписки, и направляем их владельцам mail
    #use template
#  send_mail(
 #     'Thanks for signing up!',
  #    get_template('mail/email.html').render(
   #       Context({
    #          'username': 'test_username',
   #       })
   #   ),
   #   'sakura-testmail@sakura-city.info',
  #    ['triest21@gmail.com'],
 #     fail_silently=False
 # )
  subject = 'Новая статья по Вашей подписке.'
  message = 'text version of HTML message'
  from_email =  'sakura-testmail@sakura-city.info'
  to_list =  recipient_list
  id= Article.id;

  html_message =  loader.render_to_string(
            'mail/email.html',
            {
                'article': Article,
                'author_name':author
            }
        )


  send_mail(subject, message, from_email, to_list, fail_silently=True, html_message=html_message)

  #old
  # send_mail(
   #         'New article',
   #         'Message.',
   #         'sakura-testmail@sakura-city.info',
   #        ['triest21@gmail.com'],
  #          fail_silently=False,
  #      )

def write_list_to_file(list):
    # Open the file for writing
    F = open('list.txt', 'w')

    for i in list:
        F.write(str(i) + "\n")

from django.conf import settings
base_url = settings.BASE_URL

from django import template
from django.conf import settings

base_url = settings.BASE_URL
register = template.Library()

@register.simple_tag
def add_domain(partial_url):
      return base_url + partial_url