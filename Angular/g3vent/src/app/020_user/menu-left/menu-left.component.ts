import { Component } from '@angular/core';

@Component({
  selector: 'app-menu-left',
  templateUrl: './menu-left.component.html',
  styleUrls: ['./menu-left.component.scss'],
})
export class MenuLeftComponent {
  icone_events: string = 'assets/icons/icone_events.png';
  icone_certificate: string = 'assets/icons/icone_certificate.png';
  logo_g3vent: string = 'assets/logo/logo_g3vent_bw.svg';
}
