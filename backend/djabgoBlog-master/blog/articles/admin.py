from django.contrib import admin
from .models import Article
#from .models import Subscribe
# Register your models here.
#from subscribe import Subscribe
#from blog.subscribe.models import Subscribe;

admin.site.register(Article)
#admin.site.register(Subscribe)