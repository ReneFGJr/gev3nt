import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { catchError, map, Observable, of } from 'rxjs';
import { environment } from 'src/environments/environment.prod';

@Injectable({
  providedIn: 'root',
})
export class Ge3ventServiceService {
  url_post: string = '';
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
    /********** Dados do usuário */
    if (
      this.user &&
      typeof this.user === 'object' &&
      'apikey' in this.user &&
      this.user.apikey
    ) {
      formData.append('apikey', this.user.apikey);
    } else {
      formData.append('apikey', '#');
    }

    for (const key in dt) {
      formData.append(key, dt[key]);
    }
    console.log(this.url_post)

    return this.HttpClient.post<Array<any>>(this.url_post, formData).pipe(
      map((res) => res), // Manipula a resposta da forma desejada
      catchError((error) => {
        // Manipula o erro da forma desejada, por exemplo, retornando um Observable com erro
        console.error('Erro ao verificar email', error);
        return of(error); // Retorna um Observable substituto para que o fluxo não seja interrompido
      })
    );
/*
    return this.HttpClient.post<Array<any>>(this.url_post, formData).pipe(
      (res) => res,
      (error) => error
    );
*/
  }

  getUser() {
    let user = this.get('g3vent');
    if (user) {
      return user;
    } else {
      return null;
    }
  }

  logout() {
    this.remove('g3vent');
  }
  /*
  checkEmail(email: string) {
    var formData: any = new FormData();
    formData.append('email', email);
    let url = environment.api + 'checkEmail';
    return this.HttpClient.post<Array<any>>(url, formData).pipe(
      (res) => res,
      (error) => error
    );
  }
  */
  checkEmail(email: string) {
    var formData: any = new FormData();
    formData.append('email', email);
    let url = environment.api + 'checkEmail';
    return this.HttpClient.post<Array<any>>(url, formData).pipe(
      map((res) => res), // Manipula a resposta da forma desejada
      catchError((error) => {
        // Manipula o erro da forma desejada, por exemplo, retornando um Observable com erro
        console.error('Erro ao verificar email', error);
        return of(error); // Retorna um Observable substituto para que o fluxo não seja interrompido
      })
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
