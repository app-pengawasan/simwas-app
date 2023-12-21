pipeline {
    agent any

    environment {
        APP_PATH = '/var/www/app/html/simwas-app'
        NGINX_SERVICE_NAME = 'nginx'
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
                        sh 'php artisan config:cache'
                        sh 'php artisan route:cache'
                        sh 'php artisan view:cache'
                    }
                }
            }
        }

        stage('Restart Nginx') {
            steps {
                script {
                    // Restart Nginx service
                    sh "systemctl reload ${NGINX_SERVICE_NAME}"
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
