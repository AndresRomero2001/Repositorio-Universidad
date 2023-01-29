// Nombre del alumno .....
// Andres Romero y Alberto Pascual
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <cstring>
#include <queue>
#include <cmath>
#include <unordered_map>
using namespace std;

//const int MAX = 20000;
//int visited[MAX];
//int dist[MAX];
int maxIzq, maxCentro, maxDcha;
int d;
const int INF = 1000000;
int res = -1;

int izq, centro, dcha, cant;

unordered_map<int, bool> visited;
unordered_map<int, int> dist;

void next(int act, int i) { // devuelve el sig numero y la cantidad de agua que se ha movido para llegar a ese numero
    /*int izq = act / 100;
    int centro = (act / 10) % 10;
    int dcha = act % 10;

    int cant = 0;*/

    cant = 0;

    //if (i == 0 && izq != 0 && (izq+centro) <= maxCentro) { // si toca el movimiento 0 (de izq a centro) y la jarra de la izq tiene agua, movemos agua si se puede
    //    cant = izq;
    //    izq = 0; centro = izq + centro; 
    //}
    //else if (i == 1 && izq != 0 && (izq + dcha) <= maxDcha) {
    //    cant = izq;
    //    izq = 0; dcha = izq + dcha;
    //}
    //else if (i == 2 && centro != 0 && (centro + izq) <= maxIzq) {
    //    cant = centro;
    //    centro = 0; izq = centro + izq;
    //}
    //else if (i == 3 && centro != 0 && (centro + dcha) <= maxDcha) {
    //    cant = centro;
    //    centro = 0; dcha = centro + dcha;
    //}
    //else if (i == 4 && dcha != 0 && (dcha + izq) <= maxIzq) {
    //    cant = dcha;
    //    dcha = 0; izq = dcha + izq;
    //}
    //else if (i == 5 && dcha != 0 && (dcha + centro) <= maxCentro) {
    //    cant = dcha;
    //    dcha = 0; centro = dcha + centro;
    //}
    if (i == 0 && izq != 0 && centro != maxCentro) { // si toca el movimiento 0 (de izq a centro) y la jarra de la izq tiene agua, movemos agua si se puede
        if (centro + izq <= maxCentro) { // cabia la jarra izq entera
            cant = izq;
            izq = 0;
            centro = centro + cant;
        }
        else { // no cabia la jarra izq entera
            cant = maxCentro - centro;
            izq = izq - cant;
            centro = maxCentro;
        }
    }
    else if (i == 1 && izq != 0 && dcha != maxDcha) {
        if (dcha + izq <= maxDcha) { // cabia la jarra cha entera
            cant = izq;
            izq = 0;
            dcha = dcha + cant;
        }
        else { // no cabia la jarra dcha entera
            cant = maxDcha - dcha;
            izq = izq - cant;
            dcha = maxDcha;
        }
    }
    else if (i == 2 && centro != 0 && izq != maxIzq) {
        if (centro + izq <= maxIzq) { // cabia la jarra centro entera
            cant = centro;
            centro = 0;
            izq = izq + cant;
        }
        else { // no cabia la jarra centro entera
            cant = maxIzq - izq;
            centro -= cant;
            izq = maxIzq;
        }
    }
    else if (i == 3 && centro != 0 && dcha != maxDcha) {
        if (centro + dcha <= maxDcha) {
            cant = centro;
            dcha += cant;
            centro = 0;
        }
        else {
            cant = maxDcha - dcha;
            centro -= cant;
            dcha = maxDcha;
        }
    }
    else if (i == 4 && dcha != 0 && izq != maxIzq) {
        if (dcha + izq <= maxIzq) {
            cant = dcha;
            dcha = 0;
            izq += cant;
        }
        else {
            cant = maxIzq - izq;
            dcha -= cant;
            izq = maxIzq; 
        }
    }
    else if (i == 5 && dcha != 0 && centro != maxCentro) {
        if (dcha + centro <= maxCentro) {
            cant = dcha;
            centro += cant;
            dcha = 0;
        }
        else {
            cant = maxCentro - centro;
            centro = maxCentro;
            dcha -= cant;
        }
    }

    //return { izq * 100 + centro * 10 + dcha, cant };
}

// función que resuelve el problema
bool dijkstra(int ini) {
    dist[ini] = 0;
    priority_queue<int> pq;
    pq.push(ini);
    while (!pq.empty()) {
        int act = pq.top(); pq.pop();

        for (int i = 0; i < 6; i++) { // hay 6 movimientos de jarras posibles
            /*pair<int,int> sig = next(act, i);*/
            
            /*int izq = sig.first / 100;
            int centro = (sig.first / 10) % 10;
            int dcha = sig.first % 10;*/

            /*if (izq == d || centro == d || dcha == d) {
                res = sig.first;
                dist[res] += sig.second;
                return true;
            }

            if (!visited[sig.first] && (dist[act] + sig.second) < dist[sig.first]) {
                dist[sig.first] = dist[act] + sig.second;
                visited[sig.first] = true;
                pq.push(sig.first);
            }*/

            next(act, i);

            if (izq == d || centro == d || dcha == d) {
                res = izq;
                dist[res] += cant;
                return true;
            }

            if (!visited[izq*dcha*] && (dist[act] + sig.second) < dist[sig.first]) {
                dist[sig.first] = dist[act] + sig.second;
                visited[sig.first] = true;
                pq.push(sig.first);
            }
        }
    }
    return false;
}


// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
void resuelveCaso() {
    // leer los datos de la entrada
    
    cin >> maxIzq >> maxCentro >> maxDcha;
    cin >> d;

    //cout << maxIzq << " " << maxCentro << " " << maxDcha << " " << d << endl;

    //memset(visited, false, sizeof(visited));
    //memset(dist, INF, sizeof(dist));

    for (int i = 0; i < maxIzq * maxCentro * maxDcha; i++) {
        visited[i] = false;
        dist[i] = INF;
    }

    dcha = maxDcha;
    izq = 0;
    centro = 0; 
    cant = 0;

    dijkstra(maxDcha);

    // escribir sol
    if (res != -1) cout << dist[res] << " " << d << endl;
    else cout << "No hay solucion" << endl;
    
    //cout << res << endl;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("dato.txt");
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