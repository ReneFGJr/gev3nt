import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { HeaderComponent } from './000_header/header/header.component';
import { FooterComponent } from './000_header/footer/footer.component';
import { NavbarComponent } from './000_header/navbar/navbar.component';
import { WelcomeComponent } from './010_main/welcome/welcome.component';
import { LoginComponent } from './020_user/login/login.component';
import { LogoutComponent } from './020_user/logout/logout.component';
import { PerfilComponent } from './020_user/perfil/perfil.component';
import { ReactiveFormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { MyeventsComponent } from './020_myevens/page/myevents/myevents.component';
import { MyeventsResumeComponent } from './020_myevens/page/myevents-resume/myevents-resume.component';
import { MypageComponent } from './020_user/mypage/mypage.component';
import { MenuLeftComponent } from './020_user/menu-left/menu-left.component';
import { MenuTopComponent } from './020_user/menu-top/menu-top.component';

@NgModule({
  declarations: [
    AppComponent,
    HeaderComponent,
    FooterComponent,
    NavbarComponent,
    WelcomeComponent,
    LoginComponent,
    LogoutComponent,
    PerfilComponent,
    MyeventsComponent,
    MyeventsResumeComponent,
    MypageComponent,
    MenuLeftComponent,
    MenuTopComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    NgbModule,
    ReactiveFormsModule,
    HttpClientModule,
  ],
  providers: [],
  bootstrap: [AppComponent],
})
export class AppModule {}
