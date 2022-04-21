import { Controller } from '@hotwired/stimulus';
import SwaggerUi from 'swagger-ui'

import 'swagger-ui/dist/swagger-ui.css'


export default class extends Controller {
    static values = {
        url: String
    }
    connect() {
        this.editor = SwaggerUi({
            dom_id: '#api-editor',
            deepLinking: true,
            url: this.urlValue
        })
    }
}
