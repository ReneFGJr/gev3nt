import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-widget-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.scss']
})
export class UserComponent {
  @Input() public user:Array<any> | any
}
