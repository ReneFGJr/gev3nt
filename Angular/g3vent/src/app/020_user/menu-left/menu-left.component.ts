import { Component } from '@angular/core';

@Component({
  selector: 'app-menu-left',
  templateUrl: './menu-left.component.html',
  styleUrls: ['./menu-left.component.scss'],
})
export class MenuLeftComponent {
  icone_events: string =
    'https://www.ufrgs.br/feisc/g3vent/assets/icons/icone_events.png';
  icone_certificate: string =
    'https://www.ufrgs.br/feisc/g3vent/assets/icone_certificate.png';
}
