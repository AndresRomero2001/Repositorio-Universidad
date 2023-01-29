// Nombre del alumno .....
// Andrés Romero y Alberto Pascual
// Usuario del Juez ......
// PC07

#include <iostream>
#include <iomanip>
#include <fstream>
#include <vector>
#include <cmath>
using namespace std;

int nClicks = 0;

const int MAXN = 26; // solo hay 0s y 1s
class Trie {
    int nHijos;
    int prefixes;
    int words;
    std::vector<Trie*> child;
public:
    Trie() :nHijos(0),prefixes(0), words(0), child(MAXN, nullptr) {}
    ~Trie() {
        for (int i = 0; i < MAXN; ++i)
            delete child[i];
    }

    void add(const char* s) {
        if (*s == '\0') ++words;
        else {

            Trie* t;
            if (child[*s - 'a'] == nullptr) {
                t = child[*s - 'a'] = new Trie();
                t->prefixes = 1;
                nHijos++;
            }
            else {
                t = child[*s - 'a'];
                t->prefixes++;
            }
            t->add(s + 1);
        }
    }

    //void recorrer(Trie* nodo) {
    //    int nHijos = 0;
    //    for (int i = 0; i < MAXN; i++) {
    //        
    //        if (nodo->child[i] != NULL) { // nodo child[i] es hijo
    //            nHijos++;
    //            recorrer(nodo->child[i]);
    //        }
    //    }

    //    if (nHijos > 1) { // bifurcacion
    //        nClicks++;
    //    }
    //    else if (nHijos == 1 && nodo->words > 0) { // solo 1 hijo y forma palabra
    //        nClicks++;
    //    }
    //}

    int contarClicks(Trie* nodo) {
        int nHijos = 0;
        int nClicks = 0;
        for (int i = 0; i < MAXN; i++) {
            
            if (nodo->child[i] != NULL) { // nodo child[i] es hijo
                nHijos++;
                if (nodo->child[i]->words == 1) nClicks += nodo->child[i]->prefixes;
                nClicks += contarClicks(nodo->child[i]);
            }
        }

        if (nHijos > 1 && nodo->words == 0) { // bifurcacion
            nClicks += nodo->prefixes;
        }
        
        return nClicks;
    }
};


// Resuelve un caso de prueba, leyendo de la entrada la
// configuración, y escribiendo la respuesta
bool resuelveCaso() {
    // leer los datos de la entrada
    int  nPalabras;
    cin >> nPalabras;
    if (! std::cin)
        return false;
    
    Trie arbol;
    for (int i = 0; i < nPalabras; i++) {
        string p;
        cin >> p;
        arbol.add(p.c_str());
    }
    
    // escribir sol

    double k = arbol.contarClicks(&arbol);

    cout << fixed << setprecision(2) << round(k/nPalabras*100)/100 << endl;

    nClicks = 0;
    
    return true;
    
}

int main() {
    // Para la entrada por fichero.
    // Comentar para acepta el reto
    #ifndef DOMJUDGE
     std::ifstream in("sample-50.1.in");
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