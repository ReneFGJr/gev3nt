import { Component } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-update',
  templateUrl: './update.component.html',
  styleUrls: ['./update.component.scss'],
})
export class UpdateComponent {
  public user: Array<any> | any;
  public rsp: Array<any> | any;
  public corporateBody: Array<any> | any;
  public phase: string = '1';
  public email: string = ``;
  public message_global: string = '';
  public valida_nome_message: string = '';
  public showDropdown = false;
  public busy = false;

  /* Autocomplete */
  afiliacaoControl = new FormControl();
  filteredOptions: any[] = [];

  cadastroForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private Ge3vent: Ge3ventServiceService,
    private router: Router
  ) {
    this.cadastroForm = this.fb.group({
      nome: ['', [Validators.required]],
      afiliacao: ['', [Validators.required]],
      cpf: ['', [Validators.required]],
      cracha_ufrgs: [''],
      orcid: [''],
      email: [''],
      check: [''],
    });
  }

  ngOnInit() {
    this.user = this.Ge3vent.getUser();
    this.email = this.user.email;
    this.cadastroForm.patchValue({
      email: this.user.email,
      nome: this.user.nome,
      cpf: this.user.cpf,
      cracha_ufrgs: this.user.cracha,
      afiliacao: this.user.afiliacao,
    });
  }

  validaCadastro() {}
  onSubmit() {}

  /*********************** Autocomplete */
  selectOption(option: string) {
    this.cadastroForm.patchValue({
      afiliacao: option,
    });
    this.showDropdown = false;
  }

  onRegister() {
    if (this.cadastroForm.valid) {
      this.Ge3vent.api_post(
        'g3vent/update_perfil',
        this.cadastroForm.value
      ).subscribe((res) => {
        this.rsp = res;
        if (this.rsp['status'] != '200') {
          this.message_global = this.rsp['message'];
        } else {
          this.phase = '2';
        }
      });
    } else {
      this.message_global = 'Dados obrigatórios não preenchidos';
    }
  }

  hideDropdown() {
    // Delay the hiding to allow the mousedown event on dropdown items to be processed first
    setTimeout(() => {
      this.showDropdown = false;
    }, 200);
  }

  affiliation() {
    let name = this.cadastroForm.value['afiliacao'];
    if (name.length > 1 && !this.busy) {
      this.busy = true;

      let dt: Array<any> | any = {
        q: name,
      };

      this.Ge3vent.api_post('g3vent/corporateSearch', dt).subscribe((res) => {
        this.busy = false;
        this.corporateBody = res;
        let data = this.corporateBody;
        this.filteredOptions = data;
        this.showDropdown = true;
      });

      //let data: Array<any> = [{name:'Universidade Federal do Rio Grande do Sul'}];
    } else {
      let data = [{}];
      this.filteredOptions = data;
      this.showDropdown = false;
    }
  }
}
