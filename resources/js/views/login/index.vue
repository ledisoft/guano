<template>
  <b-container>
    <b-row align-h="center" align-v="center" class="min-vh-100">
      <b-col md="6" lg="4">
        <validation-observer ref="observer" @submit.prevent="submit()">
          <b-card no-body>
            <b-card-body>
              <b-form>
                <validation-provider v-slot="errors" name="email">
                  <b-form-group>
                    <b-input-group>
                      <b-input-group-prepend>
                        <b-input-group-text>
                          <fa-icon icon="user" />
                        </b-input-group-text>
                      </b-input-group-prepend>
                      <b-form-input
                        id="email"
                        v-model="form.email"
                        type="text"
                        :state="state(errors)"
                        :placeholder="$t('general.email')"
                        autofocus
                      />
                    </b-input-group>
                    <b-form-invalid-feedback :state="state(errors)">
                      {{ errors.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </validation-provider>
                <validation-provider v-slot="errors" name="password">
                  <b-form-group>
                    <b-input-group>
                      <b-input-group-prepend>
                        <b-input-group-text>
                          <fa-icon icon="lock" />
                        </b-input-group-text>
                      </b-input-group-prepend>
                      <b-form-input
                        id="password"
                        v-model="form.password"
                        type="password"
                        :state="state(errors)"
                        :placeholder="$t('general.password')"
                      />
                    </b-input-group>
                    <b-form-invalid-feedback :state="state(errors)">
                      {{ errors.errors[0] }}
                    </b-form-invalid-feedback>
                  </b-form-group>
                </validation-provider>
                <b-button block variant="primary" type="submit" :disabled="loading">
                  <b-spinner v-if="loading" small />
                  {{ $t('auth.login') }}
                </b-button>
              </b-form>
            </b-card-body>
          </b-card>
        </validation-observer>
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
import { csrf } from '~/api/auth';
import { faUser, faLock } from '@fortawesome/free-solid-svg-icons';
import { library as FontAwesomeLibrary } from '@fortawesome/fontawesome-svg-core';

export default {
  name: 'Login',
  data() {
    return {
      form: {
        email: 'admin@example.com',
        password: 'ascent'
      },
      loading: false
    };
  },
  created() {
    FontAwesomeLibrary.add({
      faUser,
      faLock
    });
  },
  methods: {
    state({ dirty, validated, valid }) {
      return dirty || validated ? (valid ? null : valid) : null;
    },
    async submit() {
      this.loading = true;

      await csrf()
        .then(() => {
          this.$store.dispatch('auth/login', this.form)
            .then(() => {
              // TODO
            })
            .catch(error => {
              // TODO
            })
            .finally(() => {
              this.loading = false;
            });
        });
    }
  }
};
</script>

<style scoped>

</style>
