pipeline {
    agent {
        docker {
            image 'php:8.1-cli'  // Use a PHP Docker image for building and running the code
            args '-v /var/www/html'  // Mount the volume for application
        }
    }
    environment {
        REPO_URL = 'git@github.com:YourUsername/YourRepo.git'  // Update with your repo URL
        APP_DIR = '/var/www/html'  // Your app deployment directory inside container
        DOCKER_IMAGE = 'your-dockerhub-username/your-app'  // Docker image name
    }
    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: "${REPO_URL}"  // Pull code from Git repository
            }
        }
        stage('Install Dependencies') {
            steps {
                sh 'composer install'  // Install PHP dependencies using Composer
            }
        }
        stage('Run Tests') {
            steps {
                sh 'phpunit tests/'  // Run your tests (make sure PHPUnit is installed)
            }
        }
        stage('Build Docker Image') {
            steps {
                sh 'docker build -t ${DOCKER_IMAGE}:${BUILD_NUMBER} .'  // Build Docker image
            }
        }
        stage('Push Docker Image') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'dockerhub-credentials', usernameVariable: 'USERNAME', passwordVariable: 'PASSWORD')]) {
                    sh 'echo $PASSWORD | docker login -u $USERNAME --password-stdin'  // Docker login
                    sh 'docker push ${DOCKER_IMAGE}:${BUILD_NUMBER}'  // Push the Docker image to registry
                }
            }
        }
        stage('Deploy Application') {
            steps {
                sh """
                docker run -d --rm \
                -p 8080:80 \
                --name my-app \
                ${DOCKER_IMAGE}:${BUILD_NUMBER}
                """  // Deploy the app in Docker container
            }
        }
    }
    post {
        always {
            echo 'Pipeline execution completed.'  // Final message
        }
    }
}
