// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// P07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <cstring>
using namespace std;

const int MAX = 200;
vector<int> nodes;
vector<vector<int>> adjList;
bool visited[MAX];
int colores[MAX]; // aqui se guarda el color que tiene el nodo: 0 o 1
bool noBipartito = false;

// función que resuelve el problema
void dfs(int v) {
    
    visited[v] = true;
    if (v == 0) colores[v] = 0; //asignamos el primer color para poder ir calculando el resto

    for (int w : adjList[v]) {
        if (!visited[w]) {
            colores[w] = (colores[v]+1)%2; // porq el ! para invertir me daba warning
            dfs(w);
        }
        else {
            if (colores[w] == colores[v]) noBipartito=true;
        }
    }
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    int n, a; //nodos, aristas

    cin >> n;
    
    if (n==0)
        return false;
    
    cin >> a;

    /*cout << n << " " << a << endl << endl;*/

    int tam = a * 2;
    adjList.resize(200*199*2); // hay 2 elementos por arista y cada arista se mete 2 veces pq es no dirigido. El max son 200 y el max de aristas n-1
    memset(visited, false, MAX);
    memset(colores, -1, MAX);

    for (int i = 0; i < a; i++) {
        int aux1, aux2;
        cin >> aux1 >> aux2;
        adjList[aux1].push_back(aux2);
        adjList[aux2].push_back(aux1);
    }

    /*for (int i = 0; i < adjList.size(); i++) {
        for (int j = 0; j < adjList[i].size(); j++) {
            cout << i << " " << adjList[i][j] << endl;
        }
    }
    cout << endl;*/

    dfs(0);
    
    // escribir sol
    if (!noBipartito) cout << "BICOLORABLE." << endl;
    else cout << "NOT BICOLORABLE." << endl;
    

    //limpiamos la memoria de las vars globales
    for (vector<int> w : adjList) {
        w.clear();
    }
    adjList.clear();
    noBipartito = false;
    
    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("datos.txt");
     auto cinbuf = std::cin.rdbuf(in.rdbuf()); //save old buf and redirect std::cin to casos.txt
     #endif 
    
    
    while (resuelveCaso())
        ;

    
    // Para restablecer entrada. Comentar para acepta el reto
     #ifndef DOMJUDGE // para dejar todo como estaba al principio
     std::cin.rdbuf(cinbuf);
     system("PAUSE");
     #endif
    
    return 0;
}
