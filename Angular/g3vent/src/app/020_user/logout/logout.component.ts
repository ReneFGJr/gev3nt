import { Component } from '@angular/core';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-logout',
  templateUrl: './logout.component.html',
  styleUrls: ['./logout.component.scss'],
})
export class LogoutComponent {
  public user: Array<any> | any;
  constructor(public Ge3vent: Ge3ventServiceService) {}

  ngOnInit() {
    this.user = this.Ge3vent.getUser();
  }
}
