import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';
import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-events-open',
  templateUrl: './events-open.component.html',
  styleUrls: ['./events-open.component.scss'],
})
export class EventsOpenComponent {
  data: Array<any> | any;
  user: Array<any> | any;

  constructor(public Ge3vent: Ge3ventServiceService, private router: Router) {}
  ngOnInit() {
    let endpoint = 'g3vent/open';
    this.Ge3vent.api_post(endpoint).subscribe((res) => {
      this.data = res;
    });
    this.user = this.Ge3vent.getUser();
  }

  //*********************************** */
  signin(id: string) {
    this.router.navigate(['/subscribe/' + id]);
  }

  login()
    {
      this.router.navigate(['/login']);
    }
}
