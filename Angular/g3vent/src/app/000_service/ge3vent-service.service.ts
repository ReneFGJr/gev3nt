import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment.prod';

@Injectable({
  providedIn: 'root',
})
export class Ge3ventServiceService {
  url_post: string = ''
  user: Array<any> | any;

  constructor(private HttpClient: HttpClient) {
    this.storage = window.localStorage;
  }

  public api_post(
    type: string,
    dt: Array<any> = [],
    development: boolean = false
  ): Observable<Array<any>> {
    var formData: any = new FormData();
    this.user = this.getUser();

    if (development) {
      this.url_post = `${environment.url_development}` + type;
    } else {
      this.url_post = `${environment.url}` + type;
    }

    formData.append('apikey', this.user.apikey);
    console.log(this.user)

    for (const key in dt) {
      formData.append(key, dt[key]);
    }
    console.log('URL', this.url_post);
    return this.HttpClient.post<Array<any>>(this.url_post, formData).pipe(
      (res) => res,
      (error) => error
    );
  }

  getUser() {
    let user = this.get('g3vent');
    if (user) {
      return user;
    } else {
      return null;
    }
  }

  checkEmail(email: string) {
    var formData: any = new FormData();
    formData.append('email', email);
    let url = environment.api + 'checkEmail';
    return this.HttpClient.post<Array<any>>(url, formData).pipe(
      (res) => res,
      (error) => error
    );
  }

  /**************************** User */
  private storage: Storage;

  set(key: string, value: any): boolean {
    if (this.storage) {
      this.storage.setItem(key, JSON.stringify(value));
      return true;
    }
    return false;
  }

  get(key: string): any {
    if (this.storage) {
      return JSON.parse(<any>this.storage.getItem(key));
    }
    return null;
  }

  remove(key: string): boolean {
    if (this.storage) {
      this.storage.removeItem(key);
      return true;
    }
    return false;
  }

  clear(): boolean {
    if (this.storage) {
      this.storage.clear();
      return true;
    }
    return false;
  }
}
