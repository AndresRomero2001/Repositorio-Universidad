// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <cmath>
#include <algorithm>
#include <unordered_map>
using namespace std;

int nSat, nPuestos;
//typedef struct {
//    int coste;
//    pair<int, int> iniFin;
//} arista;
using arista = pair<double, pair<int, int>>;

vector<arista> v;
unordered_map<int, pair<int, int>> puestos;

struct UFDS {
    vector<int> p;
    int numSets;
    UFDS(int n) : p(n, 0), numSets(n) {
        for (int i = 0; i < n; ++i) p[i] = i;
    }
    int find(int x) {
        return (p[x] == x) ? x : p[x] = find(p[x]);
    }
    void merge(int x, int y) {
        int i = find(x), j = find(y);
        if (i == j) return;
        p[i] = j;
        --numSets;
    }
};

// función que resuelve el problema
//TipoSolucion resolver(TipoDatos datos) {
//    
//    
//}

// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    
    cin >> nSat >> nPuestos;

    for (int i = 0; i < nPuestos; i++) {
        int ini, fin;

        cin >> ini >> fin;

        puestos[i] = { ini,fin };
    }


    for (int i = 0; i < nPuestos; i++) {
        for (int j = 0; j < nPuestos; j++) {
            pair<int,int> ini, fin;
            ini = puestos[i];
            fin = puestos[j];

            int auxX, auxY;
            auxX = fin.first - ini.first;
            auxY = fin.second - ini.second;

            if (i != j) {
                int aux = auxX*auxX + auxY*auxY;
                double dist = sqrt(aux);

                arista a;
                a.first = dist;
                a.second.first = i;
                a.second.second = j;

                v.push_back(a);
            }
            

        }
    }

    sort(v.begin(), v.end());
    //cout << v[0].coste << endl;
    
    UFDS uf(nPuestos);
    int coste = 0; 
    vector<double> costes;

    for (auto ar : v) {
        if (uf.find(ar.second.first) != uf.find(ar.second.second)) {
            uf.merge(ar.second.first, ar.second.second);
            coste += ar.first;
            costes.push_back(ar.first);
            if (uf.numSets == (1 + (nSat-1))) break; // pq se pueden hacer n-1 conexiones por satelite q no tienen coste
        }
    }

    cout << fixed << setprecision(2) << costes[costes.size()-1] << endl;

    /*TipoSolucion sol = resolver(datos);*/
    // escribir sol
    
    v.clear();
    puestos.clear();
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-P10.1.in");
     auto cinbuf = std::cin.rdbuf(in.rdbuf()); //save old buf and redirect std::cin to casos.txt
     #endif 
    
    
    int numCasos;
    std::cin >> numCasos;
    for (int i = 0; i < numCasos; ++i)
        resuelveCaso();

    
    // Para restablecer entrada. Comentar para acepta el reto
     #ifndef DOMJUDGE // para dejar todo como estaba al principio
     std::cin.rdbuf(cinbuf);
     system("PAUSE");
     #endif
    
    return 0;
}