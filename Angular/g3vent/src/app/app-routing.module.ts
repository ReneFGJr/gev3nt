import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { WelcomeComponent } from './010_main/welcome/welcome.component';
import { MypageComponent } from './020_user/mypage/mypage.component';
import { LoginComponent } from './020_user/login/login.component';
import { EventsOpenComponent } from './010_main/events-open/events-open.component';
import { SubscribeComponent } from './010_main/subscribe/subscribe.component';

const routes: Routes = [
  {
    path: '',
    component: WelcomeComponent,
    children: [
      { path: '', component: EventsOpenComponent },
      { path: 'login', component: LoginComponent },
      { path: 'mypage', component: MypageComponent },
      { path: 'subscribe/:id', component: SubscribeComponent },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
