pipeline {
    agent any
    stages {
        stage('Clone Repository') {
            steps {
                git branch: 'main', url: 'https://github.com/abhithind31/wordpress.git'
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
                withCredentials([string(credentialsId: 'k8s-token', variable: 'KUBE_TOKEN')]) {
                    sh '''
                    kubectl config set-credentials jenkins --token=$KUBE_TOKEN
                    kubectl config set-context jenkins-context --cluster=kubernetes --user=jenkins
                    kubectl config use-context jenkins-context
                    kubectl set image deployment/wordpress wordpress=your-docker-repo/wordpress:latest -n wordpress
                    '''
                }
            }
        }
    }
}
