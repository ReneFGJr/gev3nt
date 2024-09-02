import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-programacao',
  templateUrl: './programacao.component.html',
  styleUrls: ['./programacao.component.scss'],
})
export class ProgramacaoComponent {

  constructor(
    private route: ActivatedRoute,
    public Ge3vent: Ge3ventServiceService
  ) {
  }

  public type: string = 'NA';
  public data: Array<any> | any;
  public sub: Array<any> | any;
  public chaves: Array<any> | any;
  public id: number = 0;

  ngOnInit() {
    this.sub = this.route.params.subscribe((params) => {
      this.id = +params['id']; // (+) converts string 'id' to a number

      /**************** Recupera e evento e tipos de inscricao */
      let endpoint = 'g3vent/schedule/'+this.id;
      let dt: any = { event: this.id };

      this.Ge3vent.api_post(endpoint, dt).subscribe((res) => {
        this.data = res;
      });
    });
  }
}
