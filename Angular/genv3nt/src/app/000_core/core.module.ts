import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CoreRoutingModule } from './core-routing.module';
import { NavbarComponent } from './core/header/navbar/navbar.component';
import { HeaderComponent } from './core/header/header/header.component';
import { FooterComponent } from './core/header/footer/footer.component';


@NgModule({
  declarations: [
    NavbarComponent,
    HeaderComponent,
    FooterComponent
  ],
  imports: [
    CommonModule,
    CoreRoutingModule
  ]
})
export class CoreModule { }
