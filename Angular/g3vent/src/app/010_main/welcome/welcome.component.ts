import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';
import { Component } from '@angular/core';

@Component({
  selector: 'app-welcome',
  templateUrl: './welcome.component.html',
  styleUrls: ['./welcome.component.scss'],
})
export class WelcomeComponent {
  constructor(g3vent: Ge3ventServiceService) {}
}
