from django.contrib.auth import login, logout;
from django.contrib.auth.forms import AuthenticationForm
from django.shortcuts import render, redirect


# Create your views here.

def singup_view(request):
    return render(request,'account/login.html')

def login_view(request):

    if request.method=='POST':
        form=AuthenticationForm(data=request.POST);
        if(form.is_valid()):
            user=form.get_user();
            login(request,user)
            #return render(request,'account/success.html')
            return redirect('articles:list')
            #if 'next' in request:
                #return redirect(request.POST.get('next'))
            #return redirect('articles:list')
        form = AuthenticationForm();
        return render(request, 'account/login.html', {'form': form})

    else:
        form=AuthenticationForm();
        return render(request,'account/login.html',{'form':form})


def logout_view(request):
    if request.method == 'POST':
        logout(request)
        return redirect('articles:list')
    return redirect('articles:list')