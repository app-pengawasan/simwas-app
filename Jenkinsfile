pipeline {
    agent any

    environment {
        APP_PATH = '/var/www/html/simwas-app'
        NGINX_SERVICE_NAME = 'nginx'
        NPM_CONFIG_CACHE = "${WORKSPACE}/.npm"
    }

    stages {
        stage('Checkout') {
            steps {
                script {
                    deleteDir()
                    checkout scm
                }
            }
        }

        stage('Update Code') {
            steps {
                script {
                    dir(APP_PATH) {
                        sh 'git pull origin main'
                    }
                }
            }
        }

        stage('Install Dependencies') {
            steps {
                script {
                    dir(APP_PATH) {
                        sh 'composer install --no-interaction --no-dev --optimize-autoloader'
                    }
                }
            }
        }

        stage('Optimize Laravel') {
            steps {
                script {
                    dir(APP_PATH) {
                        sh 'php artisan optimize:clear'
                        sh 'npm install'
                    }
                }
            }
        }

        stage('Restart Nginx') {
            steps {
                script {
                    // Restart Nginx service
                    sh "sudo /usr/sbin/service ${NGINX_SERVICE_NAME} restart"
                }
            }
        }
    }

    post {
        success {
            echo 'Deployment successful!'
        }
        failure {
            echo 'Deployment failed!'
        }
    }
}
