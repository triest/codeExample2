# Generated by Django 2.1.1 on 2018-10-04 18:20

from django.conf import settings
from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        migrations.swappable_dependency(settings.AUTH_USER_MODEL),
        ('articles', '0025_auto_20181003_0119'),
        ('subscribe', '0004_auto_20181003_2147'),
    ]

    operations = [
        migrations.CreateModel(
            name='Read',
            fields=[
                ('id', models.AutoField(primary_key=True, serialize=False)),
                ('articles_readed', models.ManyToManyField(null=True, related_name='readed', to='articles.Article')),
                ('owner_reader', models.ForeignKey(blank=True, on_delete=django.db.models.deletion.PROTECT, related_name='owner_reader', to=settings.AUTH_USER_MODEL)),
            ],
        ),
    ]