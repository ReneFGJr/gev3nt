import { Component } from '@angular/core';
import {
  AbstractControl,
  FormBuilder,
  FormControl,
  FormGroup,
  ValidatorFn,
  Validators,
} from '@angular/forms';
import { Router } from '@angular/router';
import { debounceTime, of, switchMap } from 'rxjs';
import { Ge3ventServiceService } from 'src/app/000_service/ge3vent-service.service';

@Component({
  selector: 'app-user-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent {
  phase: string = '0';
  inscricaoForm: FormGroup;
  cadastroForm: FormGroup;
  email: string = '';
  check: string = '-1-029 -0wefwe';
  busy: boolean = false;
  corporateBody: Array<any> | any;

  /* Autocomplete */
  afiliacaoControl = new FormControl();
  filteredOptions: any[] = [];
  showDropdown = false;

  valida_nome_message = '';
  message_global = '';

  ngOnInit() {
    // Setup value changes and autocomplete logic
    let data: Array<any> = [];
    this.filteredOptions = data;
    this.showDropdown = data.length > 0;
  }

  affiliation() {
    let name = this.cadastroForm.value['afiliacao'];
    if (name.length > 1 && !this.busy) {
      this.busy = true;

      let dt: Array<any> | any = {
        q: name,
      };

      this.ge3ventServiceService
        .api_post('g3vent/corporateSearch', dt)
        .subscribe((res) => {
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

  validaCadastro() {
    let validate: Boolean = true;
    let nome = this.cadastroForm.value['nome'];
    if (!this.fullNameValidator(nome)) {
      this.valida_nome_message =
        'Não pode ser inserido pontuação ou abreviações';
      validate = false;
    } else {
      this.valida_nome_message = '';
    }
    /******************************* */
    if (!this.cadastroForm.valid) {
      validate = false;
    }

    return validate;
  }

  fullNameValidator(value: string): boolean {
    if (!value) return false;

    // Remover espaços extras e dividir o nome em palavras
    const words = value.trim().split(/\s+/);

    // Verifica se há caracteres especiais proibidos
    const hasInvalidChars = /[.,/#!$%^&*;:{}=\-_`~()]/.test(value);
    if (hasInvalidChars) {
      return false;
    }

    // Verifica se cada palavra tem mais de 2 caracteres (para evitar abreviações)
    const hasAbbreviation = words.some((word) => word.length <= 2);

    // O nome é válido se houver pelo menos duas palavras, nenhuma abreviação, e nenhum caractere inválido
    return !hasAbbreviation && !hasInvalidChars;
  }

  message: string = '';
  data: Array<any> | any;
  rsp: Array<any> | any;
  constructor(
    private fb: FormBuilder,
    private ge3ventServiceService: Ge3ventServiceService,
    private router: Router
  ) {
    this.inscricaoForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
    });

    this.cadastroForm = this.fb.group({
      nome: ['', [Validators.required]],
      afiliacao: ['', [Validators.required]],
      cpf: [''],
      cracha_ufrgs: [''],
      orcid: [''],
      email: [''],
      check: [''],
    });
  }

  /*********************** Autocomplete */
  selectOption(option: string) {
    this.cadastroForm.patchValue({
      afiliacao: option,
    });
    this.showDropdown = false;
  }

  hideDropdown() {
    // Delay the hiding to allow the mousedown event on dropdown items to be processed first
    setTimeout(() => {
      this.showDropdown = false;
    }, 200);
  }

  /***************************** SIGNUP = Novo e-mail */
  onRegister() {
    if (this.validaCadastro() && this.cadastroForm.valid) {
      this.ge3ventServiceService
        .api_post('g3vent/signup', this.cadastroForm.value)
        .subscribe((res) => {
          this.rsp = res
          if (this.rsp['status'] != '200')
            {
              this.message_global = this.rsp['message']
            } else {
                this.phase = '3';
            }
        });
    } else {
      console.log('ERRO');
      this.message_global = 'Campos obrigatórios não preenchidos.';
    }
  }

  /************************ Valida e-mail */
  onSubmit() {
    /**************** Verifica se já existe o e-mail cadastrado */
    if (this.inscricaoForm.valid) {
      /****** Serviço */
      this.ge3ventServiceService
        .checkEmail(this.inscricaoForm.value.email)
        .subscribe((res) => {
          this.data = res;
          this.email = this.inscricaoForm.value.email;
          /****** Retorno */

          /***************** Usuário existe */
          if (this.data['status'] == '200') {
            this.phase = '1';
            this.ge3ventServiceService.set('g3vent', this.data);

            this.router.navigate(['/']).then(() => {
              window.location.reload();
            });

          }

          /*************** Usuário não existe */
          if (this.data['status'] == '400') {
            this.phase = '2';
            this.email = this.data['email'];

            this.cadastroForm.patchValue({
              email: this.data['email'],
              check: this.data['check'],
            });
          }
        });
    } else {
      console.log('Formulário Inválido');
      alert('Por favor, corrija os erros no formulário.');
    }
  }
}
