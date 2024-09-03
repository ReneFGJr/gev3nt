import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { WelcomeComponent } from './010_main/welcome/welcome.component';
import { MypageComponent } from './020_user/mypage/mypage.component';
import { LoginComponent } from './020_user/login/login.component';
import { EventsOpenComponent } from './010_main/events-open/events-open.component';
import { SubscribeComponent } from './010_main/subscribe/subscribe.component';
import { LogoutComponent } from './020_user/logout/logout.component';
import { ProgramacaoComponent } from './010_main/programacao/programacao.component';
import { UpdateComponent } from './020_user/update/update.component';

const routes: Routes = [
  {
    path: '',
    component: WelcomeComponent,
    children: [
      { path: '', component: EventsOpenComponent },
      { path: 'login', component: LoginComponent },
      { path: 'logout', component: LogoutComponent },
      { path: 'mypage', component: MypageComponent },
      { path: 'subscribe/:id', component: SubscribeComponent },
      { path: 'programacao/:id', component: ProgramacaoComponent },
      { path: 'update_profile', component: UpdateComponent },
    ],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
