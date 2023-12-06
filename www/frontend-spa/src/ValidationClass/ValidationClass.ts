type UserFormType = { [key: string]: string };

export default class ValidationClass {
  data: { [key: string]: string };
  rules: Array<{ [key: string]: string }>;
  result: { [key: string]: Array<string> } = {};

  stopValidate = false;
  constructor(data: UserFormType, rules: Array<{ [key: string]: string }>) {
    this.data = data;
    this.rules = rules;
  }

  makeValidation() {
    this.rules.forEach((item) => {
      const validationField: string = Object.keys(item)[0];
      const validationRules: string = Object.values(item)[0];

      // arrray like ["required", "min:8"]
      const rulesList: Array<string> = validationRules.split("|");

      for (const item of rulesList) {
        if (this.stopValidate) {
          this.stopValidate = false;
          break;
        }

        const action = item.split(":");
        switch (action[0]) {
          case "required":
            if (this.required(validationField)) {
              this.stopValidate = true;
            }
            break;
          case "min":
            if (this.min(validationField, parseInt(action[1]))) {
              this.stopValidate = true;
            }
            break;
          case "max":
            if (this.max(validationField, parseInt(action[1]))) {
              this.stopValidate = true;
            }
            break;
          case "email":
            if (this.email(validationField)) {
              this.stopValidate = true;
            }
            break;
          case "same":
            if (this.same(validationField, action[1])) {
              this.stopValidate = true;
            }
            break;
        }
      }
    });

    return this.result;
  }

  check(): boolean {
    if (Object.keys(this.result).length === 0) {
      return true;
    }

    return false;
  }

  required(field_name: string) {
    const error_message = `Поле обязательно для заполнения`;
    if (this.data[field_name].length === 0) {
      if (Object.prototype.hasOwnProperty.call(this.result, field_name)) {
        this.result[field_name].push(error_message);
      } else {
        this.result[field_name] = [];
        this.result[field_name].push(error_message);
      }
      return true;
    }
    return false;
  }

  min(field_name: string, min: number) {
    const error_message = `Минимальная длина поля - ${min} символов`;
    if (this.data[field_name].length < min) {
      if (Object.prototype.hasOwnProperty.call(this.result, field_name)) {
        this.result[field_name].push(error_message);
      } else {
        this.result[field_name] = [];
        this.result[field_name].push(error_message);
      }
      return true;
    }
    return false;
  }

  max(field_name: string, max: number) {
    const error_message = `Максимальная длина поля - ${max} символов`;
    if (this.data[field_name].length > max) {
      if (Object.prototype.hasOwnProperty.call(this.result, field_name)) {
        this.result[field_name].push(error_message);
      } else {
        this.result[field_name] = [];
        this.result[field_name].push(error_message);
      }
      return true;
    }
    return false;
  }

  email(field_name: string) {
    const re =
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    const checkEmail: boolean = re.test(
      String(this.data[field_name]).toLowerCase()
    );

    if (!checkEmail) {
      const error_message = `Email некорректный`;
      if (Object.prototype.hasOwnProperty.call(this.result, field_name)) {
        this.result[field_name].push(error_message);
      } else {
        this.result[field_name] = [];
        this.result[field_name].push(error_message);
      }
      return true;
    }
    return false;
  }

  same(field_name: string, same: string) {
    const error_message = `Пароли не совпадают`;
    if (this.data[field_name] != this.data[same]) {
      if (Object.prototype.hasOwnProperty.call(this.result, field_name)) {
        this.result[field_name].push(error_message);
      } else {
        this.result[field_name] = [];
        this.result[field_name].push(error_message);
      }
      return true;
    }
    return false;
  }
}
