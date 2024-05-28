const base_url = "http://localhost:8000/";

const post_call = async (payload, path) => {
  const res = await fetch(`${base_url}/${path}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(payload),
  });

  const res_data = res.json();

  return res_data;
};


export { post_call };
