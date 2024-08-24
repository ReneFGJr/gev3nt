import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { WelcomeComponent } from './010_main/welcome/welcome.component';
import { MypageComponent } from './020_user/mypage/mypage.component';

const routes: Routes = [
  { path: '', component: WelcomeComponent },
  { path: 'mypage', component: MypageComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
