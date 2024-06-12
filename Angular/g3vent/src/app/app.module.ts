import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { MainComponent } from './page/main/main.component';
import { HeaderComponent } from './000_header/header/header.component';
import { NavbarComponent } from './000_header/navbar/navbar.component';
import { FootComponent } from './000_header/foot/foot.component';
import { ProfileComponent } from './000_widgat/profile/profile.component';
import { ProfileUserComponent } from './000_page/profile-user/profile-user.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { SigninComponent } from './000_oauth/social/signin/signin.component';
import { SignupComponent } from './000_oauth/social/signup/signup.component';

@NgModule({
  declarations: [
    AppComponent,
    MainComponent,
    HeaderComponent,
    NavbarComponent,
    FootComponent,
    ProfileComponent,
    ProfileUserComponent,
    SigninComponent,
    SignupComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    NgbModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
