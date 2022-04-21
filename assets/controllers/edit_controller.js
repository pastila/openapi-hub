import { Controller } from '@hotwired/stimulus';
import SwaggerEditor from 'swagger-editor'

import 'swagger-editor/dist/swagger-editor.css'

export default class extends Controller {
    static values = {
        url: String
    }
    connect() {
        this.editor = SwaggerEditor({
            dom_id: '#api-editor',
            queryConfigEnabled: false,
            deepLinking: true,
            url: this.urlValue
        })
    }

    saveApi() {
        fetch(this.urlValue, {
            method: 'POST',
            body: this.editor.specSelectors.specStr()
        })
          .then(function (response){
              console.log(response)
          })
    }
}
