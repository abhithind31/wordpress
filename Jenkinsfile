pipeline {
    agent any
    stages {
        stage('Clone Repository') {
            steps {
                git 'https://github.com/abhithind31/wordpress.git'
            }
        }
        stage('Build Docker Image') {
            steps {
                sh 'docker build -t abhithind31/wordpress:latest .'
            }
        }
        stage('Push Docker Image') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'docker-hub-credentials', usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    sh '''
                    echo "$DOCKER_PASS" | docker login -u "$DOCKER_USER" --password-stdin
                    docker push abhithind31/wordpress:latest
                    '''
                }
            }
        }
        stage('Deploy to Kubernetes') {
            steps {
                sh 'kubectl set image deployment/wordpress wordpress=abhithind31/wordpress:latest -n wordpress'
            }
        }
    }
}
