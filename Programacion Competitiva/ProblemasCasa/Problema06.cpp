// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <queue>
#include <vector>
#include <string>
#include <climits>
using namespace std;

vector <vector<pair<int,int>>> adjList; // cada subvector es un vector de parejas {nIntersec, distancia}
vector<int> delays;
priority_queue<pair<int,int>, vector<pair<int, int>>, greater<pair<int,int>>> pq;
vector<int> ruta;
int numCaso = 1;

// función que resuelve el problema
void dijkstra(int ini) { // ciudad inicial
    pq.push({ 0, ini });
    while (!pq.empty()) {
        pair<int, int> front = pq.top(); 
        pq.pop();
        int delay = front.first, cruce = front.second;
        if (delay > delays[cruce]) continue; // si el delay de ir del cruce original al siguiente es mayor que el delay total que ya hay para llegar a la segunda ciudad, pq hay q hacer continue? no seria mejor hacer break? 
        for (auto a : adjList[cruce]) {
            if (delays[cruce] + a.first < delays[a.second]) {
                delays[a.second] = delays[cruce] + a.first;
                pq.push({ delays[a.second], a.second });
                ruta[a.second] = cruce;
            }
        }
    }
    
}

string escribirRuta(int ini, int fin) {
    if (ini == fin) return to_string(ini);
    return escribirRuta(ini, ruta[fin]) + " " + to_string(fin);
}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    int nReg;
    cin >> nReg;
    if (nReg == 0)
        return false;
    
    adjList.assign(nReg+1, vector<pair<int, int>>(0)); // +1 para poder obviar el elem con indice 0
    delays.assign(nReg+1, INT_MAX);
    ruta.assign(11, -1);

    for (int i = 1; i <= nReg; i++) { // para q se ajuste el num de cruce con los indices del vector
        int nCruces;
        cin >> nCruces;
        for (int j = 0; j < nCruces; j++) {
            int cruce, delay;
            cin >> cruce >> delay;
            adjList[i].push_back({ delay, cruce });
        }
    }

    int ini, dest;
    cin >> ini >> dest;
    delays[ini] = 0;
    dijkstra(ini);
    
    // escribir sol
    /*for (int i = 0; i < adjList.size(); i++) {
        cout << adjList[i].size() << " ";
        for (pair<int, int> p : adjList[i]) {
            cout << p.first << " " << p.second << " ";
        }
        cout << endl;
    }
    cout << endl;*/
  
    cout << "Case " << numCaso << ": Path = " << escribirRuta(ini,dest) << "; " << delays[dest] << " second delay" << endl;
    numCaso++;

    for (int i = 1; i <= nReg; i++) {
        adjList[i].clear();
    }
    adjList.clear();
    delays.clear();

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
