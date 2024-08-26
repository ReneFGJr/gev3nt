import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';
import { Component } from '@angular/core';

@Component({
  selector: 'app-menu-top',
  templateUrl: './menu-top.component.html',
  styleUrls: ['./menu-top.component.scss']
})
export class MenuTopComponent {
  public user:Array<any> | any
  constructor(
    public Ge3vent:Ge3ventServiceService
  ) {}

  ngOnInit()
    {
      this.user = this.Ge3vent.getUser();
    }
}
