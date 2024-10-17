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
import { EventsOpenComponent } from './010_main/events-open/events-open.component';
import { SubscribeComponent } from './010_main/subscribe/subscribe.component';
import { UserComponent } from './010_main/widget/user/user.component';
import { EventComponent } from './010_main/widget/event/event.component';
import { UserProfileComponent } from './020_user/widget/user-profile/user-profile.component';
import { ProgramacaoComponent } from './010_main/programacao/programacao.component';
import { LoadgingComponent } from './000_header/loadging/loadging.component';
import { EventDayComponent } from './010_main/widget/event-day/event-day.component';
import { EventProgrammerComponent } from './010_main/widget/event-programmer/event-programmer.component';
import { EventPersonComponent } from './010_main/widget/event-person/event-person.component';
import { UpdateComponent } from './020_user/update/update.component';
import { AboutComponent } from './010_main/about/about.component';
import { MainCertificateComponent } from './030_certificate/main-certificate/main-certificate.component';
import { UpdatedPerfilComponent } from './020_user/widget/updated-perfil/updated-perfil.component';
import { FormEmailComponent } from './030_certificate/widgat/form-email/form-email.component';
import { CertificateListComponent } from './030_certificate/widgat/certificate-list/certificate-list.component';

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
    EventsOpenComponent,
    SubscribeComponent,
    UserComponent,
    EventComponent,
    UserProfileComponent,
    ProgramacaoComponent,
    LoadgingComponent,
    EventDayComponent,
    EventProgrammerComponent,
    EventPersonComponent,
    UpdateComponent,
    AboutComponent,
    MainCertificateComponent,
    UpdatedPerfilComponent,
    FormEmailComponent,
    CertificateListComponent,
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
