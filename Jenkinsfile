pipeline {
    agent any
    stages {
        stage('Install Docker') {
            steps {
                script {
                    // Check if Docker is installed and install it if not
                    sh '''
                    if ! [ -x "$(command -v docker)" ]; then
                        echo "Docker is not installed. Installing Docker..."
                        apt-get update
                        apt-get install -y apt-transport-https ca-certificates curl software-properties-common
                        curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add -
                        add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu $(lsb_release -cs) stable"
                        apt-get update
                        apt-get install -y docker-ce
                        usermod -aG docker jenkins
                        echo "Docker installed successfully."
                    else
                        echo "Docker is already installed."
                    fi
                    '''
                }
            }
        }
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
