import { Router } from '@angular/router';
import { Ge3ventServiceService } from './../../../000_service/ge3vent-service.service';
import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-user-profile',
  templateUrl: './user-profile.component.html',
  styleUrls: ['./user-profile.component.scss'],
})
export class UserProfileComponent {
  constructor(public Ge3vent: Ge3ventServiceService, private router: Router) {}
  @Input() public user: Array<any> | any;
  @Input() public action: string = '';

  logout() {
    this.Ge3vent.logout();
    this.router.navigate(['/']).then(() => {
      window.location.reload();
    });
  }
}
