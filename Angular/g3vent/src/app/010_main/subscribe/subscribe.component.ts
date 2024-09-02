import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-subscribe',
  templateUrl: './subscribe.component.html',
  styleUrls: ['./subscribe.component.scss'],
})
export class SubscribeComponent {
  public type: string = 'NA';
  public data: Array<any> | any;
  public sub: Array<any> | any;
  public chaves: Array<any> | any;
  public id: number = 0;

  user: Array<any> | any;

  constructor(
    public Ge3vent: Ge3ventServiceService,
    private route: ActivatedRoute
  ) {}

  ngOnInit() {
    let endpoint = 'g3vent/open';
    this.Ge3vent.api_post(endpoint).subscribe((res) => {
      this.data = res;
    });

    this.user = this.Ge3vent.getUser();

    this.sub = this.route.params.subscribe((params) => {
      this.id = +params['id']; // (+) converts string 'id' to a number

      /**************** Recupera e evento e tipos de inscricao */
      let endpoint = 'g3vent/subscribeType';
      let dt: any = { event: this.id };

      console.log(dt);
      this.Ge3vent.api_post(endpoint, dt).subscribe((res) => {
        this.data = res;
      });
    });
  }

  subscribe(idt: string) {
    let user = this.data.user.id_n;
    let endpoint = 'g3vent/subscribeType';
    let dt: any = { event: this.id, event_type: idt, confirm: true };

    this.Ge3vent.api_post(endpoint, dt).subscribe((res) => {
      this.data = res;
    });
  }
}
