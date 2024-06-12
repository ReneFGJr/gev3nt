import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MainComponent } from './page/main/main.component';
import { ProfileUserComponent } from './000_page/profile-user/profile-user.component';
import { SigninComponent } from './000_oauth/social/signin/signin.component';
import { SignupComponent } from './000_oauth/social/signup/signup.component';

const routes: Routes = [
  {
    path: '',
    component: MainComponent,
    children: [
      { path: 'profile', component: ProfileUserComponent },
      { path: 'social/signin', component: SigninComponent },
      { path: 'social/signup', component: SignupComponent },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
