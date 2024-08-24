import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment.prod';


@Injectable({
  providedIn: 'root',
})
export class Ge3ventServiceService {
  constructor(private HttpClient: HttpClient) {}

  checkEmail(email: string) {
    var formData: any = new FormData();
    formData.append('email', email);
    let url = environment.api + 'checkEmail';
    return this.HttpClient.post<Array<any>>(url, formData).pipe(
      (res) => res,
      (error) => error
    );
  }
}
